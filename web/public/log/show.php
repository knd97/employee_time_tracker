<?php

require_once __DIR__ . '/../database.php';

$logsQuery = $db->query('SELECT * FROM logs l INNER JOIN workers w ON l.id_worker = w.id WHERE l.is_finished = 1');
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
			      <th scope="col">Start</th>
			      <th scope="col">Koniec</th>
			      <th scope="col">Godziny</th>
			    </tr>
			  </thead>
			  <tbody>
				<?php
				foreach ($logs as $log) {
					$diff = abs(strtotime($log['date_end']) - strtotime($log['date_start']));
					$years = floor($diff / (365*60*60*24));  
					$months = floor(($diff - $years * 365*60*60*24)/(30*60*60*24));  
					$days = floor(($diff - $years * 365*60*60*24 -$months*30*60*60*24)/ (60*60*24)); 
					$hours = floor(($diff - $years * 365*60*60*24  - $months*30*60*60*24 - $days*60*60*24) / (60*60));  
					$minutes = floor(($diff - $years * 365*60*60*24- $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);  
					echo '<tr>
							<td>'. $log['first_name'] .'</td>
							<td>'. $log['last_name'] .'</td>
							<td>'. $log['date_start'] .'</td>
							<td>'. $log['date_end'] .'</td>
							<td>'. $hours . ' godzin ' . $minutes . 'minut</td>
						</tr>';
				}
				?>
			   </tbody>
			</table>
		</div>
<?php include_once __DIR__.'/../footer.php' ?>