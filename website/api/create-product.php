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
$price = floatval(trim($_POST['price']));
$quantity = intval(trim($_POST['quantity']));
$category = trim($_POST['category']);

$imageField = "picture";

try {
	if (is_null($database->sellers->byUserId($user->id))) {
		throw new Exception("Non esiste un venditore associato a questo utente");
	}

	if (empty($name)) {
		throw new Exception("Il prodotto deve avere un nome");
	}

	if (empty($description)) {
		throw new Exception("Il prodotto deve avere una descrizione");
	}

	if ($price <= 0) {
		throw new Exception("Il prezzo deve essere maggiore di zero");
	}

	if ($quantity < 0) {
		throw new Exception("La quantità non può essere negativa");
	}

	if (!isFileUploaded($imageField)) {
		throw new Exception("È necessario fornire un'immagine");
	}

	$product = new Product();
	$product->name = $name;
	$product->description = $description;
	$product->priceInCents = intval($price * 100);
	$product->quantity = $quantity;
	$product->insertDateTime = time();
	$product->sellerId = $user->id;
	$product->category = explode(' > ', $category);

	$product->id = $database->products->add($product);
	$product->imagePath = getUploadedImage($imageField, $product->createImageBaseName());
	$database->products->update($product);
	$_SESSION['info'] = 'Prodotto creato correttamente';
	redirect('/profile/seller.php');
} catch (Exception $e) {
	$_SESSION['err'] = $e->getMessage();
	redirect('/profile/seller/new-product.php');
}

?>
