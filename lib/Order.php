<?php

namespace lib;

class Order
{
	// поля класса
	private $id;
	private $security_key;
	private $title;
	private $created_at;
	
	// массив всех заказов
	private $orderList = [];
	
	// конструктор, но в данном классе он не нужен поэтому можно удалить
	/*
	public function __construct($title = null)
	{
	}
	*/
	
	// реализация добавления
	public function add($title)
	{
		// генерируем номер заказа
		$this->id = random_int(10000, 99999);
		$this->title = $title;
		$this->security_key = null;
		$this->created_at = date('d.m.y H:i:s');
	}
	
	// реализация добавления в массив
	public function addToList($title)
	{
		$this->orderList[] = [
			'id' => random_int(10000, 99999),
			'title' => $title,
			'security_key' => md5(
				$title . ' ' . date('Y-m-d H:i:s')
			),
			'created_at' => date('d.m.y H:i:s')
		];
	}
	
	// получим информацию о заказе
	public function getOrderItem($n)
	{
		return $this->orderList[$n];
	}
	
	// получим все заказы
	public function getOrderList()
	{
		return $this->orderList;
	}
	
	// добавим геттеры на всякий случай, ниже
	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}
	
	/**
	 * @return mixed
	 */
	public function getTitle()
	{
		return $this->title;
	}
	
	/**
	 * @return mixed
	 */
	public function getSecurityKey()
	{
		return $this->security_key;
	}
	
	/**
	 * @return mixed
	 */
	public function getCreatedAt()
	{
		return $this->created_at;
	}
}