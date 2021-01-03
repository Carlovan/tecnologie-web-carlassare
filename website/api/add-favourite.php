<?php
require_once('../../config.php');
require_once(MAIN_DIR . 'utils.php');
require_once(BACKEND_D . 'database.php');

session_start();

$database = new Database();
$user = loggedUserOrRedirect($database);

$productId = $_GET['id'];
try {
	if (!$database->products->exists($productId)) {
		throw new Exception('Il prodotto richiesto non esiste');
	}
	$database->favourites->add($productId, $user->id);
	$_SESSION['info'] = 'Prodotto aggiunto ai preferiti';
} catch (Exception $e) {
	$_SESSION['err'] = $e->getMessage();
}

redirect('/product.php?id=' . $productId);

?>
