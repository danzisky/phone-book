<?php
session_start();
include '../includes/functions.inc.php';
$response = new Respond();

if(isset($_POST['submit']) && isset($_SESSION['user_id'])) {
    include '../includes/autoloader.inc.php';
    $phonebooks = new PhonebooksContr();
    $chechPhonebooks = new PhonebooksViews();
    

    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $user_id = htmlspecialchars(strtolower($_POST['user_id']));

    if (empty($name) || empty($user_id)) {
        $response->sendHeader('../index.php', 'error', 'please fill in the phonebook name');        
    } elseif (!preg_match("/^[a-z A-Z 0-9]*$/", $name)) {
        $response->sendHeader('../index.php', 'error', 'please check for invalid characters in the name field'); 
    } elseif ($user_id != $_SESSION['user_id']) {
        $response->sendHeader('../index.php', 'error', 'invalid user');
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