<?php
session_start();
include '../includes/functions.inc.php';
$response = new Respond();
$JSONResponse = new Response();

if(isset($_POST['action']) && isset($_POST['user_id'])) {
    include '../includes/autoloader.inc.php';
    $phonebooks = new PhonebooksContr();
    $checkPhonebooks = new PhonebooksViews();

    $phonebook_id = htmlspecialchars($_POST['phonebook_id']);
    $user_id = htmlspecialchars($_POST['user_id']);
    $action = htmlspecialchars($_POST['action']);

    $existingPhonebook = $checkPhonebooks->showPhonebook($phonebook_id, $user_id);

    if(empty($existingPhonebook[0]['id']) || is_null($existingPhonebook[0]['id'])) {
        $JSONResponse->generateResJSON('error', ["phonebook" => null], 'phonebook does not exist');
    } else {
        
        $action == 'share' ? $public = "1" : $public = "0";
        
        $phonebooks->updatePublicity($public, $user_id, $phonebook_id);
        $existingPhonebook = $checkPhonebooks->showPhonebook($phonebook_id, $user_id);
        if(empty($existingPhonebook[0]['id']) || $existingPhonebook[0]['public'] != $public) {
           $JSONResponse->generateResJSON('error', ["phonebook" => null], 'publicity of phonebook wasn\'t changed due to unknown errors');
        } elseif(!empty($existingPhonebook[0]['id']) && $existingPhonebook[0]['public'] == $public) {
            $JSONResponse->generateResJSON('success', ["is_public" => $existingPhonebook[0]['public']], 'publicity of phonebook was successfully changed');
        }
    }

} else {
    $JSONResponse->generateResJSON('error', ["access" => "denied"], 'invalid access');
}