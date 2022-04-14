<?php

class Contacts extends Dbh {
	protected function getContacts($user_id) {
		$sql = "SELECT * FROM contacts WHERE user_id = ?";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$user_id]);
		
		$results = $stmt->fetchAll();
		return $results;	
	}
    protected function getContactsPhonebook($user_id, $phonebook_id) {
		$sql = "SELECT * FROM contacts WHERE user_id = ? AND phonebook_id = ?";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$user_id, $phonebook_id]);
		
		$results = $stmt->fetchAll();
		return $results;	
	}
    protected function getContact($contact_id, $user_id) {
		$sql = "SELECT * FROM contacts WHERE id = ? AND user_id = ?";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$contact_id, $user_id]);
		
		$results = $stmt->fetchAll();
		return $results;	
	}
    protected function getContactName($first_name, $last_name, $user_id) {
		$sql = "SELECT * FROM contacts WHERE first_name LIKE ? OR last_name LIKE ? AND user_id = ?";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$first_name, $last_name, $user_id]);
		
		$results = $stmt->fetchAll();
		return $results;	
	}
    protected function getContactDetails($first_name, $last_name, $email, $phone, $user_id) {
		$sql = "SELECT * FROM contacts WHERE first_name = ? AND last_name = ? AND email = ? AND phone = ? AND user_id = ?";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$first_name, $last_name, $email, $phone, $user_id]);
		
		$results = $stmt->fetchAll();
		return $results;	
	}
	
	protected function setContact($phonebook_id, $user_id, $first_name, $last_name, $email, $phone, $address1, $address2, $city, $state, $zipcode, $country, $note, $contact_group) {
		$sql = "INSERT INTO contacts(phonebook_id, user_id, first_name, last_name, email, phone, address1, address2, city, state, zipcode, country, notes, contact_group) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$phonebook_id, $user_id, $first_name, $last_name, $email, $phone, $address1, $address2, $city, $state, $zipcode, $country, $note, $contact_group]);
		
	}
    protected function delContact($user_id, $contact_id) {
		$sql = "DELETE FROM contacts WHERE user_id = ? AND id = ?";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$user_id, $contact_id]);		
	}
    protected function updtVisibiity($visible, $user_id, $contact_id) {
		$sql = "UPDATE contacts SET visible = ? WHERE user_id = ? AND id = ?";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$visible, $user_id, $contact_id]);		
	}
    protected function updtContact($first_name, $last_name, $email, $phone, $address1, $address2, $city, $state, $zipcode, $country, $note, $contact_group, $user_id, $contact_id) {
		$sql = "UPDATE contacts SET first_name = ?, last_name = ?, email = ?, phone = ?, address1 = ?, address2 = ?, city = ?, state = ?, zipcode = ?, country = ?, notes = ?, contact_group = ? WHERE user_id = ? AND id = ?";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$first_name, $last_name, $email, $phone, $address1, $address2, $city, $state, $zipcode, $country, $note, $contact_group, $user_id, $contact_id]);		
	}
}