<?php

class ContactsViews extends Contacts {
	
	public function showContacts($user_id) {
		$results = $this->getContacts($user_id);
	return $results;
	}
    public function showContactsPhonebook($user_id, $phonebook_id) {
		$results = $this->getContactsPhonebook($user_id, $phonebook_id);
	return $results;
	}
    public function showContactName($first_name, $last_name, $user_id) {
		$results = $this->getContactName($first_name, $last_name, $user_id);
	return $results;
	}
    public function showIfContactExists($first_name, $last_name, $email, $phone_number, $user_id) {
		$results = $this->getContactDetails($first_name, $last_name, $email, $phone_number, $user_id);
	return $results;
	}
	public function showContact($contact_id, $user_id) {
		$results = $this->getContact($contact_id, $user_id);
	return $results; 
	}
}
		