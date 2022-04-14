<?php
session_start();
include '../includes/functions.inc.php';
$response = new Respond();
$JSONResponse = new Response();

if(isset($_POST['action']) && isset($_POST['user_id'])) {
    include '../includes/autoloader.inc.php';
    $contacts = new ContactsContr();
    $checkcontacts = new ContactsViews();

    $contact_id = htmlspecialchars($_POST['contact_id']);
    $user_id = htmlspecialchars($_POST['user_id']);
    $action = htmlspecialchars($_POST['action']);

    $existingContact = $checkcontacts->showContact($contact_id, $user_id);

    if(empty($existingContact[0]['id']) || is_null($existingContact[0]['id'])) {
        $JSONResponse->generateResJSON('error', ["contact" => null], 'contact does not exist');
    } else {
        
        $action == 'hide' ? $visible = "0" : $visible = "1";
        
        $contacts->updateVisibility($visible, $user_id, $contact_id);
        $existingContact = $checkcontacts->showContact($contact_id, $user_id);
        if(empty($existingContact[0]['id']) || $existingContact[0]['visible'] != $visible) {
           $JSONResponse->generateResJSON('error', ["contact" => null], 'visibility of contact wasn\'t changed due to unknown errors');
        } elseif(!empty($existingContact[0]['id']) && $existingContact[0]['visible'] == $visible) {
            $JSONResponse->generateResJSON('success', ["is_visible" => $existingContact[0]['visible'], "visible" => $visible], 'visibility of contact was successfully changed');
        }
    }

} else {
    $JSONResponse->generateResJSON('error', ["access" => "denied"], 'invalid access');
}