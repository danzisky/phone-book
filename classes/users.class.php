<?php

class Users extends Dbh {
	protected function getUser($email) {
		$sql = "SELECT * FROM users WHERE email = ?";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$email]);
		
		$results = $stmt->fetchAll();
		return $results;	
	}
    protected function getUserUsername($username) {
		$sql = "SELECT * FROM users WHERE username = ?";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$username]);
		
		$results = $stmt->fetchAll();
		return $results;	
	}
	
		protected function setUser($first, $last, $email, $username) {
		$sql = "INSERT INTO users(first_name, last_name, email, username) VALUES(?, ?, ?, ?)";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$first, $last, $email, $username]);
		
	}
}