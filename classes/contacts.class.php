<?php

class Contacts extends Dbh {
	protected function getContacts($user_id) {
		$sql = "SELECT * FROM contacts WHERE user_id = ?";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$user_id]);
		
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
	
	protected function setContact($phonebook_id, $user_id, $first_name, $last_name, $email, $phone_number, $address1, $address2, $city, $state, $zipcode, $country, $note, $contact_group) {
		$sql = "INSERT INTO contacts(phonebook_id, user_id, first_name, last_name, email, phone, address1, address2, city, state, vipcode, country, note, contact_group) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$phonebook_id, $user_id, $first_name, $last_name, $email, $phone_number, $address1, $address2, $city, $state, $zipcode, $country, $note, $contact_group]);
		
	}
}