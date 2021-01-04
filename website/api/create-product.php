<?php
require_once('../../config.php');
require_once(MAIN_DIR . 'utils.php');
require_once(BACKEND_D . 'database.php');
require_once(BACKEND_D . 'types/seller.php');
require_once(BACKEND_D . 'controllers/products.php');
require_once(BACKEND_D . 'controllers/images.php');

session_start();

$database = new Database();
$user = loggedUserOrRedirect($database);
$productsController = new ProductsController();
$imagesController = new ImagesController();

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

	$productsController->validateData($name, $description, $price, $quantity);

	if (!$database->categories->exists($category)) {
		throw new Exception("La categoria indicata non è valida");
	}

	if (!isFileUploaded($imageField)) {
		throw new Exception("È necessario fornire un'immagine");
	}

	$product = new Product(array(
		'name' => $name,
		'description' => $description,
		'priceInCents' => intval($price * 100),
		'quantity' => $quantity,
		'insertDateTime' => time(),
		'sellerId' => $user->id,
		'category' => $category,
		'imagePath' => ''
	));

	$database->products->assignId($product);
	$product->imagePath = $imagesController->getUploadedImage($imageField, $product->createImageBaseName());
	$database->products->add($product);
	$_SESSION['info'] = 'Prodotto creato correttamente';
	redirect('/profile/seller.php');
} catch (Exception $e) {
	$_SESSION['err'] = $e->getMessage();
	redirect('/profile/seller/new-product.php');
}

?>
