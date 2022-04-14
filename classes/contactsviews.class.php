<?php

class ContactsViews extends Contacts {
	
	public function showContacts($user_id) {
		$results = $this->getContacts($user_id);
	return $results;
	}
    public function showPhonebookName($first_name, $last_name, $user_id) {
		$results = $this->getContactName($first_name, $last_name, $user_id);
	return $results;
	}
	public function showPhonebook($contact_id, $user_id) {
		$results = $this->getContact($contact_id, $user_id);
	return $results; 
	}
}
		