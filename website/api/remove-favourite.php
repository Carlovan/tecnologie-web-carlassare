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
	$database->favourites->remove($productId, $user->id);
	$_SESSION['info'] = 'Prodotto rimosso dai preferiti';
} catch (Exception $e) {
	$_SESSION['err'] = $e->getMessage();
}

if (isset($_GET['toUser'])) {
	redirect('/profile/favourites.php');
} else {
	redirect('/product.php?id=' . $productId);
}

?>
