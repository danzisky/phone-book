<?php

class Phonebooks extends Dbh {
	protected function getPhonebooks($user_id) {
		$sql = "SELECT * FROM phonebooks WHERE user_id = ?";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$user_id]);
		
		$results = $stmt->fetchAll();
		return $results;	
	}
    protected function getPhonebook($phonebook_id, $user_id) {
		$sql = "SELECT * FROM phonebooks WHERE id = ? AND user_id = ?";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$phonebook_id, $user_id]);
		
		$results = $stmt->fetchAll();
		return $results;	
	}
    protected function getPhonebookName($phonebook_name, $user_id) {
		$sql = "SELECT * FROM phonebooks WHERE phonebook_name = ? AND user_id = ?";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$phonebook_name, $user_id]);
		
		$results = $stmt->fetchAll();
		return $results;	
	}
	
	protected function setPhonebook($name, $user_id, $description) {
		$sql = "INSERT INTO phonebooks(phonebook_name, user_id, phonebook_description) VALUES(?, ?, ?)";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$name, $user_id, $description]);
		
	}
}