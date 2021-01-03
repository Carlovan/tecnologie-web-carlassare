<?php
require_once('../../config.php');
require_once(MAIN_DIR . 'utils.php');
require_once(BACKEND_D . 'database.php');
require_once(BACKEND_D . 'controllers/images.php');

session_start();

$database = new Database();
$imagesController = new ImagesController();
$user = loggedUserOrRedirect($database);
$productId = $_GET['id'];

try {
	if (is_null($database->sellers->byUserId($user->id))) {
		throw new Exception("Nessun venditore è associato a questo utente");
	}
	$product = $database->products->get($productId);
	if (is_null($product)) {
		throw new Exception("Il prodotto specificato non esiste");
	}
	if ($product->sellerId !== $user->id) {
		throw new Exception("Non sei autorizzato ad eliminare questo prodotto");
	}

	$database->products->remove($product->id);
	$imagesController->removeImage($product->imagePath);
	$_SESSION['info'] = 'Prodotto rimosso correttamente';
} catch (Exception $e) {
	$_SESSION['err'] = $e->getMessage();
}

redirect('/profile/seller.php');
?>
