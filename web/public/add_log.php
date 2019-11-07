<?php 
if (isset($_GET['token'])) {
	require_once __DIR__ . '/database.php';

	$token = filter_input(INPUT_GET, 'token');
	$workerQuery = $db->prepare('SELECT * FROM workers WHERE token = :token');
	$workerQuery->bindValue(':token', $token, PDO::PARAM_STR);
	$workerQuery->execute();
	$worker = $workerQuery->fetch();

	if (false === $worker) {
		$stmt = $db->prepare('INSERT INTO tokens VALUES(NULL, :token, now()) ON DUPLICATE KEY UPDATE `date`=now()');
		$stmt->bindValue(':token', $token, PDO::PARAM_STR);
		$stmt->execute();
		// return false dont opne
	} elseif ($worker['is_active']) {
		$stmt = $db->prepare('INSERT INTO logs VALUES(NULL, :id_user, now())');
		$stmt->bindValue(':id_user', $worker['id'], PDO::PARAM_INT);
		$stmt->execute();
		// return true open
	} else {
		// return false dont open
	}
}

?>