<?php


class PhonebooksContr extends Phonebooks {
	public function createPhonebook($name, $user_id, $description) {
		$this->setPhonebook($name, $user_id, $description); 
	}
    public function updatePublicity($public, $user_id, $phonebook_id) {
		$this->updtPublicity($public, $user_id, $phonebook_id); 
	}
    public function deletePhonebook($user_id, $phonebook_id) {
		$this->delPhonebook($user_id, $phonebook_id); 
	}
    public function updatePhonebook($name, $description, $user_id, $phonebook_id) {
		
		$this->updtPhonebook($name, $description, $user_id, $phonebook_id); 
	} 	
}