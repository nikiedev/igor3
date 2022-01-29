<?php

/*
 * Принципы ООП:
 * 1 - инкапсуляция (сокрытие данных)
 * 2 - наследование (базовый класс содержит общий функционал)
 * 3 - полиморфизм (одинаковое название, разное поведение)
 */

namespace Lib;

class User
{
	protected $id = 1;
	protected $name = null;
	
	public function __construct($name = 'None')
	{
		$this->id = rand(1000, 9999);
		$this->name = $name;
	}
	
	public function show()
	{
		echo
			'ID: ' . $this->id . '<br>' .
			'Имя: ' . $this->name . '<br>';
	}
	
	public function setName($name)
	{
		$this->name = $name;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function saveUser($data)
	{
		// $pass = $data['pass'];
		$this->generateKey();
		setcookie('user', $this->name, 60);
	}
	
	public function getData($data = [])
	{
		if (!empty($data))
		{
			return $data;
		}
		return [
			'key1' => 111,
			'key2' => 222
		];
	}
	
	private function generateKey()
	{
	
	}
}
