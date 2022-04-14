<?php
session_start();
include '../includes/functions.inc.php';
$response = new Respond();

if(isset($_POST['delete']) && isset($_SESSION['user_id'])) {
    include '../includes/autoloader.inc.php';
    $contacts = new ContactsContr();
    $checkContacts = new ContactsViews();

    $contact_id = $_POST['contact_id'];
    $user_id = $_POST['user_id'];

    if ($user_id != $_SESSION['user_id']) {
        $response->sendHeader('../phonebook.php', 'error', 'invalid user');
    } 

    $existingContactID = $checkContacts->showContact($contact_id, $user_id);

    if(empty($existingContactID[0]['id']) || is_null($existingContactID[0]['id'])) {
        $response->sendHeader('../phonebook.php', 'error', 'the contact does not exist');
    } else {
        $visible = "0";
        $contacts->updateVisibility($visible, $user_id, $contact_id);
        $existingContactID = $checkContacts->showContact($contact_id, $user_id);
        if($existingContactID[0]['visible'] != $visible) {
            $response->sendHeader('../phonebook.php', 'error', 'the contact visibility wasn\'t changed due to unknown errors');
        } elseif($existingContactID[0]['visible'] == $visible) {
            $response->sendHeader('../phonebook.php', 'success', 'visibiliy was successfully changed');
        }
    }

} else {
    $response->sendHeader('../index.php', 'error', 'invalid access');
}