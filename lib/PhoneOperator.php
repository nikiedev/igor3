<?php

namespace Lib;

class PhoneOperator
{
	private $name;
	private $clientCount;
    private $db;
	
	public function __construct($name = 'не указано', $clientCount = 0)
	{
		$this->name = $name;
		$this->clientCount = $clientCount;
	}
	
	public function clientCountUp($n) {
		$this->clientCount += $n;
	}
	
	public function clientCountDown($n) {
		$this->clientCount -= $n;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getClientCount() {
		return $this->clientCount;
	}
    
    public function saveOperator($name, $clientCount) {
        return $this->db->table('operators')->insert([
            'name' => $name,
            'client_count' => $clientCount
        ]);
    }
    
    public function getOperator($name, $date) {
         return $this->db->table('operators')->where(
             'name', '=', $name
         )->between(
             'created_at',
             $date . ' 00:00:00',
             $date . ' 23.59.59'
         )->getAll();
    }
    
    public function setDbConnection($db) {
        $this->db = $db;
    }
	
}