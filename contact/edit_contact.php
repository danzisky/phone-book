<?php
session_start();
include '../includes/functions.inc.php';
$response = new Respond();

if(isset($_POST['submit']) && isset($_SESSION['user_id'])) {
    include '../includes/autoloader.inc.php';
    $contacts = new ContactsContr();
    $checkContacts = new ContactsViews();
    

    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $last_name = htmlspecialchars(trim($_POST['last_name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $address1 = htmlspecialchars(trim($_POST['address1']));
    $address2 = htmlspecialchars(trim($_POST['address2']));
    $city = htmlspecialchars(trim($_POST['city']));
    $state = htmlspecialchars(trim($_POST['state']));
    $zipcode = htmlspecialchars(trim($_POST['zipcode']));
    $country = htmlspecialchars(trim($_POST['country']));
    $note = htmlspecialchars(trim($_POST['notes']));
    $contact_group = htmlspecialchars(trim($_POST['contact_group']));
    $contact_id = htmlspecialchars(trim($_POST['contact_id']));
    $user_id = htmlspecialchars(trim($_POST['user_id']));

    $ownsContact = $checkContacts->showContact($contact_id, $user_id);
    if (empty($first_name) && empty($last_name)) {
        $response->sendHeader('../edit_contact.php', 'error', 'please fill in the name of your contact');        
    } if (empty($email) && empty($phone)) {
        $response->sendHeader('../edit_contact.php', 'error', 'please add a contact means, at least an email or a phone number');        
    }
     elseif (!preg_match('/^[\w\s\d]*$/i', $first_name) || !preg_match('/^[\w\s\d]*$/i', $last_name)) {
        $response->sendHeader('../edit_contact.php', 'error', 'please check if you\'ve inputed non alphabetic characters'); 
    } elseif ($user_id != $_SESSION['user_id']) {
        $response->sendHeader('../edit_contact.php', 'error', 'invalid user');
    } elseif(empty($ownsContact[0]['id']) || is_null($ownsContact[0]['id'])) {
        $response->sendHeader('../edit_contact.php', 'error', 'sorry, the contact does not belong to this user'.$ownsContact[0]['user_id']);
    } elseif($ownsContact[0]['id'] == $contact_id) {
       
        $contacts->updateContact($first_name, $last_name, $email, $phone, $address1, $address2, $city, $state, $zipcode, $country, $note, $contact_group, $user_id, $contact_id);

        $existingContact = $checkContacts->showIfContactExists($first_name, $last_name, $email, $phone, $user_id);
        if(empty($existingContact[0]['id']) || is_null($existingContact[0]['id'])) {
            $response->sendHeader('../edit_contact.php', 'error', 'contact wasn\'t updated due to unknown errors');
        } elseif(!empty($existingContact[0]['id']) || !is_null($existingContact[0]['id'])) {
            $response->sendHeader('../phonebook.php', 'success', 'contact was successfully updated');
        }
        
    }


    

} else {
    $response->sendHeader('../index.php', 'error', 'invalid access');
}