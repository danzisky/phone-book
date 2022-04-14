<?php

class ContactsContr extends Contacts {
	public function createContact($phonebook_id, $user_id, $first_name, $last_name, $email, $phone_number, $address1, $address2, $city, $state, $zipcode, $country, $note, $contact_group) {
		$this->setContact($phonebook_id, $user_id, $first_name, $last_name, $email, $phone_number, $address1, $address2, $city, $state, $zipcode, $country, $note, $contact_group); 
	} 	
}