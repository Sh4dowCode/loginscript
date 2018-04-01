<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'inc/variables.php';

$con = new mysqli($mysql_server, $mysql_user, $mysql_password, $mysql_database);
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
} 
if (!isset($_SESSION['id'])) {
	$logsql = "SELECT * FROM `user` WHERE `username` = '".$_POST['username']."' OR `email` = '".$_POST['username']."'";

	$logrow = mysqli_query($con, $logsql);

	$logrow = mysqli_fetch_assoc($logrow);

	$pwhash = $logrow['password'];
	$id = $logrow['id'];
	$name = $logrow['name'];

	if (password_verify($_POST['password'], $pwhash)) {
	  $_SESSION['id'] = $id;
	  $_SESSION['name'] = $name;
	  if ($_POST['kmsibox'] == 'true') {
		$salt = '123';
		$secsalt = '456';
		$username = $_POST['username'];
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		$unhashed = "".$salt.$username.$ip.$secsalt."";

		$options = [
			'cost' => 12,
		];
		$value = password_hash($unhashed, PASSWORD_BCRYPT, $options);

		setcookie("kmsi-hash", $value, time()+5184000);
		
		$hashsql = "UPDATE `user` SET `hash`='".$value."' WHERE `id` = '".$id."'";
		$hashrow = mysqli_query($con, $hashsql);
	  }
	  header("Location: ./index.php");
		echo 'Success!';
	} else {
	  header("Location: ./login/index.php?loger");
		die('Invalid, please retry. <a href="./login/index.php" class="btn btn-info" role="button">Back</a>');
	}
}

if (isset($_SESSION['id'])) {
header("Location: ./index.php");
		echo 'Success!';
}
?>