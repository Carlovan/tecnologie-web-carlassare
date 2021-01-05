<?php
require_once('../../config.php');
require_once(MAIN_DIR . 'utils.php');
require_once(BACKEND_D . 'database.php');

session_start();

header('Content-type: application/json');

function sendError($msg) {
	echo '{"error": "' . $msg . '"}';
	exit;
}

$database = new Database();
$user = loggedUser($database);
if (is_null($user)) {
	sendError("L'utente specificato non esiste");
}

$productId = $_POST['productId'];
$quantity = intval($_POST['quantity']);
if ($quantity <= 0) {
	sendError("La quantità indicata non è valida");
}

$cartProduct = $database->cart->get($productId, $user->id);
if (is_null($cartProduct)) {
	sendError("Il prodotto specificato non esiste");
}
if (!$cartProduct->checkNewQuantity($quantity)) {
	sendError("Non c'è abbastanza disponibilità");
}
$cartProduct->quantity = $quantity;
$database->cart->update($cartProduct);
 
echo '{}';
?>
