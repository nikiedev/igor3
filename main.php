<?php

//include_once 'lib/User.php';
//include_once 'lib/Player.php';
//include_once 'lib/Profile.php';
//include_once 'lib/PhoneOperator.php';

require_once 'vendor/autoload.php';

use Lib\User;
use Lib\Player;
use Lib\Profile;
use Lib\PhoneOperator;

$user = new User('Гость');
$user->show();

$oldName = $user->getName();

$user->setName('Игорь');
echo '<p>Имя ' . $oldName . ' изменилось на ' . $user->getName() . '</p>';
$user->show();

$player = new Player('Igrok', 50);
$player->show();



//$player->saveUser($_POST);


echo '<hr>';

$profile = new Profile('Николай', 'Свинцов');
$profile->setEmail('myemail@gmail.com');
$profile->setSkype('skynet.eresta');
$profile->displayInfo();

//$sql = "SELECT * FROM tablename";
//mysqli_query($coonection, $sql);


// PHP DATA OBJECT

echo '<hr>';

$operator = new PhoneOperator('Mikola', 5);
echo '<p>Оператор 1: ' . $operator->getName() .
	', клиентов на данный момент: ' . $operator->getClientCount() . '</p>';
$operator2 = new PhoneOperator('Anna', 3);
$text = "<p>Оператор 2: {$operator2->getName()}
	, клиентов на данный момент: . {$operator2->getClientCount()} </p>";
//mail('admin@example.com', 'Вопрос с сайта', 'Сообщение:<br>' . $text);

//$nums = preg_replace('/[^0-9]/', '',  '+5abc10631112233');
//echo $nums;


$config = [
	'host'		=> 'localhost',
	'driver'	=> 'mysql',
	'database'	=> 'test',
	'username'	=> 'root',
	'password'	=> '',
	'charset'	=> 'utf8',
	'collation'	=> 'utf8_general_ci',
	'prefix'	 => ''
];

$db = new \Buki\Pdox($config);

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
</head>
<body>
<form action="" method="post">
	<input type="text">
</form>
</body>
</html>
