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

$name = trim($_POST['name']);
$description = trim($_POST['description']);
$website = trim($_POST['website']);

$imageField = 'profilePic';

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

	if (!isFileUploaded($imageField)) {
		throw new Exception("È necessario fornire una immagine");
	}


	$seller = new Seller(array(
		'userId' => $user->id,
		'name' => $name,
		'website' => empty($website) ? NULL : $website,
		'description' => $description,
		'imagePath' => ''
	));
	$seller->imagePath = $imagesController->getUploadedImage($imageField, $seller->createImageBaseName());

	$database->sellers->add($seller);
	$_SESSION['info'] = 'Profilo venditore creato correttamente';
} catch (Exception $e) {
	$_SESSION['err'] = $e->getMessage();
}

redirect('/profile/seller.php');
?>
