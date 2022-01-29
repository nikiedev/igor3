<?php

namespace Lib;

class Profile extends User
{
	private $lastname;
	private $email = '<не указано>';
	private $skype = '<не указано>';
	private $viber = '<не указано>';
	private $telegramm = '<не указано>';
	
	public function __construct($name = 'None', $lastname = 'не указано')
	{
		parent::__construct($name);
		$this->lastname = $lastname;
	}
	
	public function displayInfo() {
	    echo
		    '<p>name: ' . $this->name . '</p>' .
		    '<p>lastname: ' . $this->lastname . '</p>' .
	        '<p>email: ' . $this->email . '</p>' .
	        '<p>skype: ' . $this->skype . '</p>' .
	        '<p>viber: ' . $this->viber . '</p>' .
	        '<p>telegramm: ' . $this->telegramm . '</p>';
	}
	
	public function setEmail($value) {
		$this->email = $value;
	}
	
	public function setSkype($value) {
		$this->skype = $value;
	}
	
	public function setViber($value) {
		$this->viber = $value;
	}
	
	public function setTelegram($value) {
		$this->telegramm = $value;
	}
	
	public function getEmail() {
		return $this->email;
	}
	
	public function getSkype() {
		return $this->skype;
	}
	
	public function getViber() {
		return $this->viber;
	}
	
	public function getTelegram() {
		return $this->telegramm;
	}
}
