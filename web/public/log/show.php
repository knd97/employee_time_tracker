<?php

require_once __DIR__ . '/../database.php';

if (isset($_POST['worker'])) {
	$logsQuery = $db->prepare('SELECT * FROM logs l INNER JOIN workers w ON l.id_worker = w.id WHERE l.is_finished = 1 AND w.id = :id');
	$logsQuery->bindValue(':id', $_POST['worker'], PDO::PARAM_INT);
} else {
	$logsQuery = $db->prepare('SELECT * FROM logs l INNER JOIN workers w ON l.id_worker = w.id WHERE l.is_finished = 1');
}
$logsQuery->execute();
$logs = $logsQuery->fetchAll();

$workersQuery = $db->query('SELECT * FROM workers');
$workers = $workersQuery->fetchAll();
?>

<?php $title = "Logi"; include_once __DIR__.'/../head.php' ?>
<?php include_once __DIR__.'/../nav.php' ?>

		<div class="row mt-5 mb-4">
			<h1>Logi</h1>
		</div>

		<div class="mb-3">
			<form method="post">
				<div class="form-row">
					<div class="col-1 pt-2">
						<h6>
							Pracownik:
						</h6>
					</div>
					<div class="col-4">
						<select class="form-control" name="worker">
							<option disabled selected value> -- wybierz -- </option>
							<?php 
								foreach ($workers as $worker) {
									echo '<option value ="' . $worker['id'] . '">' . $worker['last_name'] . ' ' . $worker['first_name'] . '</option>';
								}
							?>
						</select>
					</div>
					<div class="col-2">
						<button type="submit" class="btn btn-primary">Wybierz</button>
					</div>
				</div>
			</form>
		</div>

		<div class="row">
			<table class="table">
			  <thead>
			    <tr>
			      <th scope="col">Imie</th>
			      <th scope="col">Nazwisko</th>
			      <th scope="col">Start</th>
			      <th scope="col">Koniec</th>
			      <th scope="col">Godziny</th>
			    </tr>
			  </thead>
			  <tbody>
				<?php
				$sumTime = 0;
				foreach ($logs as $log) {
					$diff = abs(strtotime($log['date_end']) - strtotime($log['date_start']));
					$years = floor($diff / (365*60*60*24));  
					$months = floor(($diff - $years * 365*60*60*24)/(30*60*60*24));  
					$days = floor(($diff - $years * 365*60*60*24 -$months*30*60*60*24)/ (60*60*24)); 
					$hours = floor(($diff - $years * 365*60*60*24  - $months*30*60*60*24 - $days*60*60*24) / (60*60));  
					$minutes = floor(($diff - $years * 365*60*60*24- $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 
					$sumTime += $diff; 
					echo '<tr>
							<td>'. $log['first_name'] .'</td>
							<td>'. $log['last_name'] .'</td>
							<td>'. $log['date_start'] .'</td>
							<td>'. $log['date_end'] .'</td>
							<td>'. $hours . ' godzin ' . $minutes . 'minut</td>
						</tr>';
				}

				$years = floor($sumTime / (365*60*60*24));  
				$months = floor(($sumTime - $years * 365*60*60*24)/(30*60*60*24));  
				$days = floor(($sumTime - $years * 365*60*60*24 -$months*30*60*60*24)/ (60*60*24)); 
				$hours = floor(($sumTime - $years * 365*60*60*24  - $months*30*60*60*24 - $days*60*60*24) / (60*60));  
				$minutes = floor(($sumTime - $years * 365*60*60*24- $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
				echo '<tr> <td></td> <td></td> <td></td> <td></td> <td>'. $hours . ' godzin ' . $minutes . 'minut</td> </tr>'
				?>
			   </tbody>
			</table>
		</div>
<?php include_once __DIR__.'/../footer.php' ?>