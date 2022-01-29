<?php

namespace Lib;

class Player extends User
{
	private $level = 1;
	
	public function __construct($name = 'None', $level = 1)
	{
		parent::__construct($name);
		$this->level = $level;
	}
	
	public function show()
	{
		parent::show();
		echo 'Уровень: ' . $this->level;
	}
}