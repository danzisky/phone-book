<?php
session_start();
include '../includes/functions.inc.php';
$response = new Respond();

if(isset($_POST['submit'])) {
    include '../includes/autoloader.inc.php';
    $users = new UsersContr();
    $checkUsers = new UsersView();
    

    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name = htmlspecialchars($_POST['last_name']);
    $username = htmlspecialchars(strtolower(php_strip_whitespace($_POST['username'])));
    $email = htmlspecialchars($_POST['email']);

    if (empty($first_name) || empty($last_name) || empty($email) || empty($username)) {
        $response->sendHeader('../index.php', 'error', 'please fill in all fields');        
    } elseif (!preg_match("/^[a-z A-Z 0-9]*$/", $last_name) || !preg_match("/^[a-z A-Z . _]*$/", $first_name)) {
        $response->sendHeader('../index.php', 'error', 'please check for invalid characters in the name field'); 
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response->sendHeader('../index.php', 'error', 'please make sure your email has a valid format');
    } 
    

    $existingUserEmail = $checkUsers->showUser($email);
    $existingUserUsername = $checkUsers->showUserUsername($username);

    if(!empty($existingUserEmail[0]['id']) || !is_null($existingUserEmail[0]['id'])) {
        $response->sendHeader('../index.php', 'error', 'email has already been used');
    } elseif(!empty($existingUserUsername[0]['id']) || !is_null($existingUserUsername[0]['id'])) {
        $response->sendHeader('../index.php', 'error', 'username has already been used');
    } else {
        $users->createUser($first_name, $last_name, $email, $username);

        $existingUserEmail = $checkUsers->showUser($email);
        if(empty($existingUserEmail[0]['id']) || is_null($existingUserEmail[0]['id'])) {
            $response->sendHeader('../index.php', 'error', 'account wasn\'t created due to unknown errors');
        } elseif(!empty($existingUserEmail[0]['id']) || !is_null($existingUserEmail[0]['id'])) {
            $response->sendHeader('../index.php', 'success', 'user successfully added');
        }
    }

} else {
    $response->sendHeader('../index.php', 'error', 'invalid access');
}