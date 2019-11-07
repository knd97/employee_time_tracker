<?php

require_once __DIR__ . '/../database.php';

$logsQuery = $db->query('SELECT * FROM logs l INNER JOIN workers w ON l.id_user = w.id');
$logs = $logsQuery->fetchAll();
?>

<?php $title = "Logi"; include_once __DIR__.'/../head.php' ?>
<?php include_once __DIR__.'/../nav.php' ?>

		<div class="row mt-5 mb-4">
			<h1>Logi</h1>
		</div>

		<div class="row">
			<table class="table">
			  <thead>
			    <tr>
			      <th scope="col">Imie</th>
			      <th scope="col">Nazwisko</th>
			      <th scope="col">Data</th>
			    </tr>
			  </thead>
			  <tbody>
				<?php
				foreach ($logs as $log) {
					echo '<tr>
							<td>'. $log['first_name'] .'</td>
							<td>'. $log['last_name'] .'</td>
							<td>'. $log['date'] .'</td>
						</tr>';
				}
				?>
			   </tbody>
			</table>
		</div>
<?php include_once __DIR__.'/../footer.php' ?>