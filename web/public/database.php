<?php

$config = require_once __DIR__ . '/config.php';

try {
	
	$db = new PDO("mysql:host={$config['host']};dbname={$config['database']};charset=utf8", $config['user'], $config['password'], [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
	]);
	
} catch (PDOException $error) {
	
	echo $error->getMessage();
	exit(' Database error');
}
