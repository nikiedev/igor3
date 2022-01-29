<?php

include_once 'lib/PdoxInterface.php';
include_once 'lib/Cache.php';
include_once 'lib/Pdox.php';

use Buki\PdoxInterface;
use Buki\Cache;
use Buki\Pdox;

session_start();

if (isset($_GET['logout']) and $_GET['logout'] == 'yes') {
	session_unset();
	session_destroy();
	header('Location: security.php');
	exit;
}

if (!empty($_POST)) {
	
	$login = trim($_POST['login']);
	$pass = trim($_POST['pass']);
//	$text = htmlspecialchars(trim($_POST['text']));
//	$n = round(trim($_POST['price']), 2); // 35.54    43sdfw30.545654
	
	$db = new Pdox([
		'host'		=> 'localhost',
		'driver'	=> 'mysql',
		'database'	=> 'igor3',
		'username'	=> 'root',
		'password'	=> 'root'
	]);
	
	$user = $db->table('users')
		->where('login', $login)
		->get();
	
	if (!empty($user)) {
		if (password_verify($pass, $user->pass)) {
			//echo 'Данные совпали!';
			$_SESSION['user'] = $user;
			header('Location: security.php');
			exit;
		} else {
			header('Refresh:5;url=security.php');
			echo 'Неверные данные!';
			exit;
		}
	}
	
//	echo '<pre>';
//	print_r($user->login);
//	echo '</pre>';
//	die;
	
}

//$login = 'admin';
//$pass = 'admin';
//$hash = '$2y$10$BLE/z30kSaUofQu.4umyYeKHuhvpPmBMhfaV9Zt80M7TAalR/hBga';
//$md5Pass = md5($pass);
//echo $md5Pass;


//$hash = password_hash($pass, PASSWORD_DEFAULT);
//echo $hash;

//if (password_verify($pass, $hash)) {
//	echo 'Данные совпали!';
//} else {
//	echo 'Неверные данные!';
//}
$user = null;
if (isset($_SESSION['user'])) {
	$user = $_SESSION['user'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>

<?php if (isset($user)) : ?>
<p>
	ID: <?php echo $user->id; ?>
</p>
<p>
	Имя: <?php echo $user->login; ?>
</p>
<p>
	<a href="security.php?logout=yes">Выйти</a>
</p>
<?php else : ?>
<form action="" method="post">
	<input placeholder="Логин" name="login" type="text">
	<input placeholder="Пароль" name="pass" type="text">
	<button>Войти</button>
</form>
<?php endif; ?>

</body>
</html>
