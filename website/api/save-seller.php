<?php
require_once('../../config.php');
require_once(MAIN_DIR . 'utils.php');
require_once(BACKEND_D . 'database.php');
require_once(BACKEND_D . 'types/seller.php');

session_start();

$database = new Database();
$user = loggedUserOrRedirect($database);

$name = trim($_POST['name']);
$description = trim($_POST['description']);
$website = trim($_POST['website']);

try {
	$seller = $database->sellers->byUserId($user->id);
	if (is_null($seller)) {
		throw new Exception("Nessun venditore è associato a questo utente");
	}

	$otherSeller = $database->sellers->byName($name);
	if (!is_null($otherSeller) && $otherSeller->userId !== $user->id) {
		throw new Exception("Questo nome è già utilizzato da un altro venditore");
	}

	if (!empty($website) && filter_var($website, FILTER_VALIDATE_URL) === false) {
		throw new Exception("L'indirizzo web specificato non è valido");
	}

	$seller->name = $name;
	$seller->website = empty($website) ? NULL : $website;
	$seller->description = $description;

	$database->sellers->update($seller);
	$_SESSION['info'] = 'Profilo venditore aggiornato correttamente';
} catch (Exception $e) {
	$_SESSION['err'] = $e->getMessage();
}

redirect('/profile/seller.php');
?>
