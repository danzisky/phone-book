<?php
session_start();
include '../includes/functions.inc.php';
$response = new Respond();

if(isset($_POST['delete']) && isset($_SESSION['user_id'])) {
    include '../includes/autoloader.inc.php';
    $phonebooks = new PhonebooksContr();
    $checkPhonebooks = new PhonebooksViews();

    $phonebook_id = htmlspecialchars($_POST['phonebook_id']);
    $user_id = htmlspecialchars($_POST['user_id']);

    if ($user_id != $_SESSION['user_id']) {
        $response->sendHeader('../account.php', 'error', 'invalid user');
    } 

    $existingPhonebookname = $checkPhonebooks->showPhonebook($phonebook_id, $user_id);

    if(empty($existingPhonebookname[0]['id']) || is_null($existingPhonebookname[0]['id'])) {
        $response->sendHeader('../account.php', 'error', 'phonebook does not exist');
    } else {
        $phonebooks->deletePhonebook($user_id, $phonebook_id);
        $existingPhonebookname = $checkPhonebooks->showPhonebook($phonebook_id, $user_id);
        if(!empty($existingPhonebookname[0]['id']) || !is_null($existingPhonebookname[0]['id'])) {
            $response->sendHeader('../account.php', 'error', 'phonebook wasn\'t deleted due to unknown errors');
        } elseif(empty($existingPhonebookname[0]['id']) || is_null($existingPhonebookname[0]['id'])) {
            $response->sendHeader('../account.php', 'success', 'phonebook was successfully deleted');
        }
    }

} else {
    $response->sendHeader('../index.php', 'error', 'invalid access');
}