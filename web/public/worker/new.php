<?php 

if (isset($_POST['first_name'])) {
	require_once __DIR__ . '/../database.php';

	$firstName = filter_input(INPUT_POST, 'first_name');
	$lastName = filter_input(INPUT_POST, 'last_name');
	$token = filter_input(INPUT_POST, 'token');
	$isActive = 0;
	if (isset($_POST['is_active'])) {
		$isActive = 1;
	}
	
	$stmt = $db->prepare('INSERT INTO workers VALUES (NULL, :firstName, :lastName, :token, :isActive)');
	$stmt->bindValue(':firstName', $firstName, PDO::PARAM_STR);
	$stmt->bindValue(':lastName', $lastName, PDO::PARAM_STR);
	$stmt->bindValue(':token', $token, PDO::PARAM_STR);
	$stmt->bindValue(':isActive', $isActive, PDO::PARAM_BOOL);
	$stmt->execute();

	$stmt = $db->prepare('UPDATE tokens SET is_active = 1 WHERE token = :token');
	$stmt->bindValue(':token', $token, PDO::PARAM_STR);
	$stmt->execute();

	header('Location: show.php');
	exit();
}

?>
<?php $title = "Dodaj pracownika"; include_once __DIR__.'/../head.php' ?>
<?php include_once __DIR__.'/../nav.php' ?>

		<div class="row mt-5 mb-4 ">
			<h1>Dodaj pracownika</h1>
		</div>

		<div class="row">
			<form method="post">
			  <div class="form-group">
			    <label>Imie</label>
			    <input type="test" class="form-control" name="first_name">
			  </div>
			  <div class="form-group">
			    <label>Nazwisko</label>
			    <input type="test" class="form-control" name="last_name">
			  </div>
			  <div class="form-group">
			    <label>Token</label>
			    <input type="test" class="form-control" name="token">
			  </div>


			  <div class="form-group form-check">
			    <input type="checkbox" class="form-check-input" name="is_active">
			    <label class="form-check-label">Aktywny</label>
			  </div>
			  <button type="submit" class="btn btn-primary">Submit</button>
			</form>

		</div>		

<?php include_once __DIR__.'/../footer.php' ?>