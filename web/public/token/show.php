<?php

require_once __DIR__ . '/../database.php';

$tokensQuery = $db->query('SELECT * FROM tokens WHERE is_active = 0');
$tokens = $tokensQuery->fetchAll();
?>

<?php $title = "Token"; include_once __DIR__.'/../head.php' ?>
<?php include_once __DIR__.'/../nav.php' ?>

		<div class="row mt-5 mb-4">
			<h1>Nieaktywne tokeny</h1>
		</div>

		<div class="row">
			<table class="table">
			  <thead>
			    <tr>
			      <th scope="col">Token</th>
			      <th scope="col">Data użycia</th>
			    </tr>
			  </thead>
			  <tbody>
				<?php
				foreach ($tokens as $token) {
					echo '<tr>
							<td>'. $token['token'] .'</td>
							<td>'. $token['date'] .'</td>
						</tr>';
				}
				?>
			   </tbody>
			</table>

		</div>
	
<?php include_once __DIR__.'/../footer.php' ?>