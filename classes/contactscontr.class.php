<?php

class ContactsContr extends Contacts {
	public function createContact($phonebook_id, $user_id, $first_name, $last_name, $email, $phone_number, $address1, $address2, $city, $state, $zipcode, $country, $note, $contact_group) {
		$this->setContact($phonebook_id, $user_id, $first_name, $last_name, $email, $phone_number, $address1, $address2, $city, $state, $zipcode, $country, $note, $contact_group); 
	}
    public function updateVisibility($visible, $user_id, $contact_id) {
		$this->updtVisibiity($visible, $user_id, $contact_id); 
	}
    public function deleteContact($user_id, $contact_id) {
		$this->delContact($user_id, $contact_id); 
	}
    public function updateContact($first_name, $last_name, $email, $phone, $address1, $address2, $city, $state, $zipcode, $country, $note, $contact_group, $user_id, $contact_id) {
		$this->updtContact($first_name, $last_name, $email, $phone, $address1, $address2, $city, $state, $zipcode, $country, $note, $contact_group, $user_id, $contact_id); 
	} 	
}