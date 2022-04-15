<?php
session_start();
include '../includes/functions.inc.php';
$response = new Respond();

if(isset($_POST['submit'])) {
    include '../includes/autoloader.inc.php';
    $checkUsers = new UsersView();
    
    $username = htmlspecialchars(trim(strtolower($_POST['username'])));
    $email = htmlspecialchars(trim($_POST['email']));

    if (!preg_match('/^[\w\d]+$/i', $username, $matches)) {
        $response->sendHeader('../index.php', 'error', 'invalid character in username');        
    } elseif (empty($email) || empty($username)) {
        $response->sendHeader('../index.php', 'error', 'please fill in all fields');        
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response->sendHeader('../index.php', 'error', 'please make sure your email has a valid format');
    } else {
        $existingUserEmail = $checkUsers->showUser($email);
        $existingUserUsername = $checkUsers->showUserUsername($username);

        if(empty($existingUserEmail[0]['id']) || is_null($existingUserEmail[0]['id'])) {
            $response->sendHeader('../index.php', 'error', 'Sorry the user with the email doesn\'t exist');
        } elseif(empty($existingUserUsername[0]['id']) || is_null($existingUserUsername[0]['id'])) {
            $response->sendHeader('../index.php', 'error', 'Sorry the user with the username doesn\'t exist'.$username."fff");
        } else {
            $existingUserEmail = $checkUsers->showUser($email);
            $existingUserUsername = $checkUsers->showUserUsername($username);
            if(empty($existingUserEmail[0]['id']) || is_null($existingUserEmail[0]['id'])) {
                $response->sendHeader('../index.php', 'error', 'no account was found');
            } elseif(!empty($existingUserEmail[0]['id']) || !is_null($existingUserEmail[0]['id'])) {
                $_SESSION['user_id'] = $existingUserEmail[0]['id'];
                $_SESSION['first_name'] = $existingUserEmail[0]['first_name'];
                $_SESSION['last_name'] = $existingUserEmail[0]['last_name'];
                $_SESSION['user_name'] = $existingUserEmail[0]['username'];
                $_SESSION['email'] = $existingUserEmail[0]['email'];
                $response->sendHeader('../account.php', 'success', 'logged in successfully as'.$existingUserEmail[0]['first_name']);            
            }
        }
    } 
    

    

} else {
    $response->sendHeader('../index.php', 'error', 'invalid access');
}