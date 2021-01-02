<?php
require_once('../../config.php');
require_once(MAIN_DIR . 'utils.php');
require_once(BACKEND_D . 'database.php');
require_once(BACKEND_D . 'types/seller.php');
require_once(BACKEND_D . 'controllers/products.php');

session_start();

$database = new Database();
$user = loggedUserOrRedirect($database);
$productsController = new ProductsController();

$name = trim($_POST['name']);
$description = trim($_POST['description']);
$price = floatval(trim($_POST['price']));
$quantity = intval(trim($_POST['quantity']));
$category = trim($_POST['category']);
$productId = $_POST['productId'];

$imageField = "picture";

try {
	if (is_null($database->sellers->byUserId($user->id))) {
		throw new Exception("Non esiste un venditore associato a questo utente");
	}
	$product = $database->products->get($productId);
	if (is_null($product)) {
		throw new Exception("Il prodotto specificato non esiste");
	}
	if ($product->sellerId !== $user->id) {
		throw new Exception("Non sei autorizzato a modificare questo prodotto");
	}

	$productsController->validateData($name, $description, $price, $quantity);

	$product->name = $name;
	$product->description = $description;
	$product->priceInCents = intval($price * 100);
	$product->quantity = $quantity;
	$product->category = explode(' > ', $category);

	if (!isFileUploaded($imageField)) {
		$product->imagePath = getUploadedImage($imageField, $product->createImageBaseName());
	}
	$database->products->update($product);

	$_SESSION['info'] = 'Modifiche salvate correttamente';
} catch (Exception $e) {
	$_SESSION['err'] = $e->getMessage();
}
redirect('/profile/seller/edit-product.php?id=' . $productId);

?>
