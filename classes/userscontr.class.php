<?php

class UsersContr extends Users {
	public function createUser($first, $last, $email, $username) {
		$this->setUser($first, $last, $email, $username); 
	} 	
}