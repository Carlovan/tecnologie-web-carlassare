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
	if (!is_null($database->sellers->byUserId($user->id))) {
		throw new Exception("Esiste già un venditore associato a questo utente");
	}
	if (!is_null($database->sellers->byName($name))) {
		throw new Exception("Questo nome è già utilizzato da un altro venditore");
	}

	if (!empty($website) && filter_var($website, FILTER_VALIDATE_URL) === false) {
		throw new Exception("L'indirizzo web specificato non è valido");
	}

	$seller = new Seller();
	$seller->userId = $user->id;
	$seller->name = $name;
	$seller->website = empty($website) ? NULL : $website;
	$seller->description = $description;

	$database->sellers->add($seller);
	$_SESSION['info'] = 'Profilo venditore creato correttamente';
} catch (Exception $e) {
	$_SESSION['err'] = $e->getMessage();
}

redirect('/profile/seller.php');
?>
