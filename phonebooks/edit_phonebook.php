<?php
session_start();
include '../includes/functions.inc.php';
$response = new Respond();

if(isset($_POST['submit']) && isset($_SESSION['user_id'])) {
    include '../includes/autoloader.inc.php';
    $phonebooks = new PhonebooksContr();
    $checkPhonebooks = new PhonebooksViews();
    

    $name = htmlspecialchars(trim($_POST['name']));
    $description = $_POST['description'];
    $user_id = htmlspecialchars(trim($_POST['user_id']));
    $phonebook_id = htmlspecialchars(trim($_POST['phonebook_id']));

    if (empty($name) || empty($user_id)) {
        $response->sendHeader('../edit_phonebook.php', 'error', 'please fill in the phonebook name');        
    } elseif (!preg_match('/^[\w\d]+$/i', $name)) {
        $response->sendHeader('../edit_phonebook.php', 'error', 'please check for invalid characters in the name field'); 
    } elseif ($user_id != $_SESSION['user_id']) {
        $response->sendHeader('../account.php', 'error', 'invalid user');
    } else {
        $phonebooks->updatePhonebook($name, $description, $user_id, $phonebook_id);

        $existingPhonebookname = $checkPhonebooks->showPhonebookName($name, $user_id);

        if(empty($existingPhonebookname[0]['id']) || is_null($existingPhonebookname[0]['id']) || $existingPhonebookname[0]['phonebook_name'] != $name || $existingPhonebookname[0]['phonebook_description'] != $description) {
            $response->sendHeader('../edit_phonebook.php', 'error', 'an error occured, phonebook could not be updated');
        } else {
            $response->sendHeader('../account.php', 'success', 'successfully updated phonebook');
        }
    }
    
    

} else {
    $response->sendHeader('../index.php', 'error', 'invalid access');
}