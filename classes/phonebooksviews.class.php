<?php

class PhonebooksViews extends Phonebooks {
	
	public function showPhonebooks($user_id) {
		$results = $this->getPhonebooks($user_id);
	return $results;
	}
    public function showPhonebookName($name, $user_id) {
		$results = $this->getPhonebookName($name, $user_id);
	return $results;
	}
	public function showPhonebook($phonebook_id, $user_id) {
		$results = $this->getPhonebook($phonebook_id, $user_id);
	return $results; 
	}
}
		