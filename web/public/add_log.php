<?php 
if (isset($_GET['token'])) {
	require_once __DIR__ . '/database.php';

	$token = filter_input(INPUT_GET, 'token');
	$workerQuery = $db->prepare('SELECT * FROM workers WHERE token = :token');
	$workerQuery->bindValue(':token', $token, PDO::PARAM_STR);
	$workerQuery->execute();
	$worker = $workerQuery->fetch();

	if (false === $worker) {
		$stmt = $db->prepare('INSERT INTO tokens VALUES(NULL, :token, now(), 0) ON DUPLICATE KEY UPDATE `date`=now()');
		$stmt->bindValue(':token', $token, PDO::PARAM_STR);
		$stmt->execute();
		echo 'false';
	} elseif ($worker['is_active']) {
		$logQuery = $db->prepare('SELECT * FROM logs WHERE id_worker = :idUser and is_finished = 0 and date_end IS NULL');
		$logQuery->bindValue(':idUser', $worker['id'], PDO::PARAM_INT);
		$logQuery->execute();
		$log = $logQuery->fetch();

		if (false === $log) {
			$stmt = $db->prepare('INSERT INTO logs VALUES(NULL, :id_worker, now(), NULL, 0)');
			$stmt->bindValue(':id_worker', $worker['id'], PDO::PARAM_INT);
		} else {
			$stmt = $db->prepare('UPDATE logs SET date_end = now(), is_finished = 1 WHERE id = :id');
			$stmt->bindValue(':id', $log['id'], PDO::PARAM_INT);
		}
		$stmt->execute();

		echo 'true';
	} else {
		echo 'false';
	}
}

?>