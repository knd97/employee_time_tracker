<?php 
if (isset($_GET['id'])) {
	require_once __DIR__ . '/../database.php';

	$id = filter_input(INPUT_GET, 'id');
	$workerQuery = $db->prepare('DELETE FROM workers WHERE id = :id');
	$workerQuery->bindValue(':id', $id, PDO::PARAM_INT);
	$workerQuery->execute();
}

header('Location: show.php');
exit();
?>