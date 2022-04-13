<?php

class PhonebooksContr extends Phonebooks {
	public function createPhonebook($name, $user_id, $description) {
		$this->setPhonebook($name, $user_id, $description); 
	} 	
}