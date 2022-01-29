<?php

require_once 'vendor/autoload.php';

use Buki\Pdox;
use Lib\PhoneOperator;

$db = new Pdox([
	'host'		=> 'localhost',
	'driver'	=> 'mysql',
	'database'	=> 'igor3',
	'username'	=> 'root',
	'password'	=> 'root',
	'charset'	=> 'utf8',
	'collation'	=> 'utf8_general_ci',
	'prefix'	 => ''
]);

$phoneOperator = new PhoneOperator();
$phoneOperator->setDbConnection($db);
$operators = [];

if (isset($_GET['name']) and !empty($_GET['name']))
{
	$name = trim($_GET['name']);
	$date = $_GET['date']; // date('d.m.Y', strtotime($_GET['date']));
    
    $operators = $phoneOperator->getOperator($name, $date);
}

if (isset($_POST['name']) and !empty($_POST['name']))
{
    $name = trim($_GET['name']);
    $clientCount = (int)trim($_GET['client_count']);
    
    $result = $phoneOperator->saveOperator($name, $clientCount);
	print_r($result);
}

//$operators = $db->table('operators')->getAll();

?>

<!doctype html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Document</title>
</head>
<body>

<?php if (isset($result)): ?>
<?= '<p>Запись добавлена</p>'; ?>
<?php endif; ?>

<h2>Добавить нового оператора</h2>
<form action="" method="post">
	<input type="text" placeholder="Имя" name="name">
	<input type="text" placeholder="Колличество" name="client_count">
	<button>Добавить</button>
</form>

<h2>Список операторов</h2>
<form action="" method="get">
	<input type="text" placeholder="Имя" name="name">
	<input type="date" name="date">
	<button>Выбрать</button>
</form>
<div class="list">
	<?php if (count($operators) > 0) : ?>
	<?php foreach ($operators as $operator) : ?>
	<div class="item">
		<p>
			<strong>Имя:</strong> <?= $operator->name; ?>
			<strong>Колличество клиентов:</strong> <?= $operator->client_count; ?>
			<strong>Дата:</strong> <?= $operator->created_at; ?>
		</p>
	</div>
	<?php endforeach; ?>
	<?php else : ?>
	<p>
		За выбранный период никого не найдено
	</p>
	<?php endif; ?>
</div>

</body>
</html>
