<?php

// подключение файла
require_once 'vendor/autoload.php';

// используем пространство имен \Lib\Order,
// так как класс лежит по пути lib/Order.php
use Lib\Order;

$order = new Order(); // создаем объект класса
$order->add('Ноутбук Asus 2201'); // создаем новый заказ. мы указали только наименование но номер заказа, ключ безопасности и дата оформления - автоматически формируется.

// теперь добавим еще парочку заказов но пусть это будет новый объект:
$order2 = new Order();
$order2->addToList('Смартфон AC1122'); // создаем новый заказ и сохраняем его в массив внутри класса
$order2->addToList('Планшет XXI');
$order2->addToList('iPhone 9010');
$orderList = $order2->getOrderList(); // вернет список сохраненный заказов

dd($orderList ); // выведем и посмотрим что вышло


//$item = $order->getOrderItem(0); // возвращает массив с информацией о конкретном заказе:
//echo '<pre>';
//print_r($item); // выведем и посмотрим что вышло
//echo '</pre>';

?>

<!DOCTYPE html>
<html>
<head>
    <title>Блоки</title>
    <meta charset="utf-8">
</head>
<body>
<!--
неправильно

<input type="id" name="id" />
<input type="security_key" name="security_key" />
<input type="title" name="title" />
<input type="created_at" name="created_at" />
-->

<!--
правильно

<form action="" method="post">
	<input type="text" placeholder="Название заказа" name="title" />
	<button>Добавить</button>
</form>

но пока будем без html, вся логика в файле Order.php,
а вызов методов - наверху этого файла
-->
</body>
</html>