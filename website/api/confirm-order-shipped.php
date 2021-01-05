<?php
require_once('../../config.php');
require_once(MAIN_DIR . 'utils.php');
require_once(BACKEND_D . 'database.php');

session_start();

$database = new Database();
$user = loggedUserOrRedirect($database);
if (is_null($database->sellers->byUserId($user->id))) {
	redirect('/profile/seller.php');
}

$order = $database->orders->get($_GET['id']);
if (is_null($order)) {
	redirect('/profile/seller/orders.php');
}
$purchasedProducts = $order->getProductsBySellerId($user->id);
if (empty($purchasedProducts)) {
	redirect('/profile/seller/orders.php');
}

foreach ($purchasedProducts as $p) {
	$database->purchasedProducts->setShipped($p->orderId, $p->originalProductId);
}

$msg = 'Il prodotto <b>' . $purchasedProducts[0]->productName . '</b> ';
if (count($purchasedProducts) > 1) {
	$msg .= 'e ' . count($purchasedProducts) . 'altr' . (count($purchasedProducts) == 2 ? 'o' : 'i') . ' sono stati spediti';
} else {
	$msg .= 'è stato spedito';
}
$database->notifications->add(new Notification(array(
	'message' => $msg,
	'userId' => $user->id,
	'dateTime' => time()
)));

redirect('/profile/seller/orders.php');

?>
