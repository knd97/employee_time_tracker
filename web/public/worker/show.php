<?php

require_once __DIR__ . '/../database.php';

$workersQuery = $db->query('SELECT * FROM workers');
$workers = $workersQuery->fetchAll();
?>

<?php $title = "Pracownicy"; include_once __DIR__.'/../head.php' ?>
<?php include_once __DIR__.'/../nav.php' ?>

		<div class="row mt-5 mb-4">
			<h1>Pracownicy</h1>
		</div>

		<div class="row mb-4">
			<a href="new.php">Dodaj pracownika</a>
		</div>

		<div class="row">
			<table class="table">
			  <thead>
			    <tr>
			      <th scope="col">Imie</th>
			      <th scope="col">Nazwisko</th>
			      <th scope="col">Token</th>
			      <th scope="col">Aktywny</th>
			      <th scope="col">Usun</th>
			    </tr>
			  </thead>
			  <tbody>
				<?php
				foreach ($workers as $worker) {
					echo '<tr>
							<td>'. $worker['first_name'] .'</td>
							<td>'. $worker['last_name'] .'</td>
							<td>'. $worker['token'] .'</td>
							<td>'. $worker['is_active'] .'</td>
							<td><a href="delete.php?id='. $worker['id'] .'">Usun</a></td>
						</tr>';
				}
				?>
			   </tbody>
			</table>
		</div>
<?php include_once __DIR__.'/../footer.php' ?>