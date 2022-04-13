<?php

class UsersView extends Users {
	
	public function showUser($email) {
		$results = $this->getUser($email);
	return $results;
	}
    public function showUserUsername($username) {
		$results = $this->getUserUsername($username);
	return $results;
	}
	public function showUserPwd($email) {
		$results = $this->getUser($email);
	return $results; 
	}
}
		