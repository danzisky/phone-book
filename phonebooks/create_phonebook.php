<?php
session_start();
include '../includes/functions.inc.php';
$response = new Respond();

if(isset($_POST['submit']) && isset($_SESSION['user_id'])) {
    include '../includes/autoloader.inc.php';
    $phonebooks = new PhonebooksContr();
    $checkPhonebooks = new PhonebooksViews();
    

    $name = htmlspecialchars($_POST['name']);
    $description = htmlspecialchars($_POST['description']);
    $user_id = htmlspecialchars(strtolower($_POST['user_id']));

    if (empty($name) || empty($user_id)) {
        $response->sendHeader('../account.php', 'error', 'please fill in the phonebook name');        
    } elseif (!preg_match("/^[a-z A-Z 0-9]*$/", $name)) {
        $response->sendHeader('../account.php', 'error', 'please check for invalid characters in the name field'); 
    } elseif ($user_id != $_SESSION['user_id']) {
        $response->sendHeader('../account.php', 'error', 'invalid user');
    } 
    

    $existingPhonebookname = $checkPhonebooks->showPhonebookName($name, $user_id);

    if(!empty($existingPhonebookname[0]['id']) || !is_null($existingPhonebookname[0]['id'])) {
        $response->sendHeader('../account.php', 'error', 'you have already used this Phonebook name, please coose another name');
    } else {
        $phonebooks->createPhonebook($name, $user_id, $description);
        $existingPhonebookname = $checkPhonebooks->showPhonebookName($name, $user_id);
        if(empty($existingPhonebookname[0]['id']) || is_null($existingPhonebookname[0]['id'])) {
            $response->sendHeader('../account.php', 'error', 'phonebook wasn\'t created due to unknown errors');
        } elseif(!empty($existingPhonebookname[0]['id']) || !is_null($existingPhonebookname[0]['id'])) {
            $response->sendHeader('../account.php', 'success', 'phonebook was successfully created');
        }
    }

} else {
    $response->sendHeader('../index.php', 'error', 'invalid access');
}