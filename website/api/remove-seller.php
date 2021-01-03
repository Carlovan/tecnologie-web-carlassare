<?php
require_once('../../config.php');
require_once(MAIN_DIR . 'utils.php');
require_once(BACKEND_D . 'database.php');
require_once(BACKEND_D . 'types/seller.php');
require_once(BACKEND_D . 'controllers/images.php');

session_start();

$database = new Database();
$imagesController = new ImagesController();
$user = loggedUserOrRedirect($database);

try {
	$seller = $database->sellers->byUserId($user->id);
	if (is_null($seller)) {
		throw new Exception("Nessun venditore è associato a questo utente");
	}

	$products = $database->products->bySellerId($seller->userId);
	foreach ($products as $p) {
		$database->products->remove($p->id);
	}

	$database->sellers->remove($seller->userId);
	$imagesController->removeImage($seller->imagePath);
	$_SESSION['info'] = 'Profilo venditore rimosso correttamente';
} catch (Exception $e) {
	$_SESSION['err'] = $e->getMessage();
}

redirect('/profile/seller.php');
?>
