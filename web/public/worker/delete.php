<?php 
if (isset($_GET['id'])) {
	require_once __DIR__ . '/../database.php';

	$id = filter_input(INPUT_GET, 'id');
	$workerQuery = $db->prepare('SELECT * FROM workers where id = :id');
	$workerQuery->bindValue(':id', $id, PDO::PARAM_INT);
	$workerQuery->execute();
	$worker = $workerQuery->fetch();

	if (false !== $worker) {

		$stmt = $db->prepare('UPDATE tokens SET is_active = 0 WHERE token = :token');
		$stmt->bindValue(':token', $worker['token'], PDO::PARAM_STR);
		$stmt->execute();

		$stmt = $db->prepare('DELETE FROM workers WHERE id = :id');
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
	}

}

header('Location: show.php');
exit();
?>