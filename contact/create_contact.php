<?php
session_start();
include '../includes/functions.inc.php';
$response = new Respond();

if(isset($_POST['submit']) && isset($_SESSION['user_id'])) {
    include '../includes/autoloader.inc.php';
    $contacts = new ContactsContr();
    $checkContacts = new ContactsViews();
    $checkPhonebook = new PhonebooksViews();
    

    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name = htmlspecialchars($_POST['last_name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $address1 = htmlspecialchars($_POST['address1']);
    $address2 = htmlspecialchars($_POST['address2']);
    $city = htmlspecialchars($_POST['city']);
    $state = htmlspecialchars($_POST['state']);
    $zipcode = htmlspecialchars($_POST['zipcode']);
    $country = htmlspecialchars($_POST['country']);
    $note = htmlspecialchars($_POST['notes']);
    $contact_group = htmlspecialchars($_POST['contact_group']);
    $phonebook_id = htmlspecialchars($_POST['phonebook_id']);
    $user_id = htmlspecialchars($_POST['user_id']);

    $ownsPhonebook = $checkPhonebook->showPhonebook($phonebook_id, $user_id);
    if (empty($first_name) && empty($last_name)) {
        $response->sendHeader('../phonebook.php', 'error', 'please fill in the name of your contact');        
    } if (empty($email) && empty($phone)) {
        $response->sendHeader('../phonebook.php', 'error', 'please add a contact means, at least an email or a phone number');        
    }
     elseif (!preg_match("/^[a-z A-Z 0-9]*$/", $first_name) || !preg_match("/^[a-z A-Z 0-9]*$/", $last_name) || !preg_match("/^[a-z A-Z 0-9]*$/", $country) || !preg_match("/^[a-z A-Z 0-9]*$/", $city) || !preg_match("/^[a-z A-Z 0-9]*$/", $state) || !preg_match("/^[a-z A-Z 0-9]*$/", $contact_group)) {
        $response->sendHeader('../phonebook.php', 'error', 'please check if you\'ve inputed non alpha numeric characters'); 
    } elseif ($user_id != $_SESSION['user_id']) {
        $response->sendHeader('../phonebook.php', 'error', 'invalid user');
    } elseif(empty($ownsPhonebook[0]['id']) || is_null($ownsPhonebook[0]['id'])) {
        $response->sendHeader('../phonebook.php', 'error', 'sorry, the phonebook does not belong to this user'.$phonebook_id.$ownsPhonebook[0]['user_id']);
    } elseif($ownsPhonebook[0]['id'] == $phonebook_id) {

        $existingContact = $checkContacts->showIfContactExists($first_name, $last_name, $email, $phone, $user_id);
        if(!empty($existingContact[0]['id']) || !is_null($existingContact[0]['id'])) {
            $response->sendHeader('../phonebook.php', 'error', 'you have already added this contact, with same names');
        } else {
            $contacts->createContact($phonebook_id, $user_id, $first_name, $last_name, $email, $phone, $address1, $address2, $city, $state, $zipcode, $country, $note, $contact_group);

            $existingContact = $checkContacts->showIfContactExists($first_name, $last_name, $email, $phone, $user_id);
            if(empty($existingContact[0]['id']) || is_null($existingContact[0]['id'])) {
                $response->sendHeader('../phonebook.php', 'error', 'contact wasn\'t created due to unknown errors');
            } elseif(!empty($existingContact[0]['id']) || !is_null($existingContact[0]['id'])) {
                $response->sendHeader('../phonebook.php', 'success', 'contact was successfully added to this pbonebook');
            }
        }
    }


    

} else {
    $response->sendHeader('../index.php', 'error', 'invalid access');
}