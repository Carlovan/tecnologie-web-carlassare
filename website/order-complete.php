<?php
require_once('../config.php');
require_once(MAIN_DIR . 'utils.php');
require_once(FRAGS_D . 'page_delimiters.php');
require_once(BACKEND_D . 'database.php');
require_once(BACKEND_D . 'controllers/notifications.php');
require_once(BACKEND_D . 'types/order.php');
require_once(BACKEND_D . 'types/purchased-product.php');

session_start();

$database = new Database();
$user = loggedUserOrRedirect($database);
$notificationsController = new NotificationsController($database);

$entries = $database->cart->byUserId($user->id);
if (empty($entries)) {
	redirect('/');
}

// Create the order
$order = new Order(array(
	'userId' => $user->id,
	'dateTime' => time(),
	'shippingAddress' => $user->shippingAddress->format()
), $database);

$database->orders->assignId($order);

function convertEntryToPurchasedProduct($entry) {
	global $order, $database;
	return new PurchasedProduct(array(
		'orderId' => $order->id,
		'productId' => $entry->productId,
		'quantity' => $entry->quantity,
		'productName' => $entry->getProduct()->name,
		'priceInCents' => $entry->getProduct()->priceInCents,
		'sellerName' => $entry->getProduct()->getSeller()->name
	), $database);
}
$purchasedProducts = array_map('convertEntryToPurchasedProduct', $entries);

$database->orders->add($order);
$database->purchasedProducts->addAll($purchasedProducts);

// Update the sold count and available quantity
foreach ($purchasedProducts as $pp) {
	$product = $pp->getProduct();
	$product->soldCount++;
	$product->quantity--;
	$database->products->update($product);
	if ($product->quantity == 0) {
		$notificationsController->send($product->sellerId, 'Il tuo prodotto <b>' . $product->name . '</b> è terminato!!');
	} else if ($product->quantity < QUANTITY_ALERT) {
		$notificationsController->send($product->sellerId, 'Il tuo prodotto <b>' . $product->name . '</b> è quasi terminato');
	}
}

// Send notification to involved sellers
$sellers = array();
foreach ($purchasedProducts as $pp) {
	$sellers[] = $pp->getProduct()->sellerId;
}
$sellers = array_unique($sellers);
foreach ($sellers as $s) {
	$notificationsController->send($s, 'Qualcuno ha comprato un tuo prodotto!!');
}

$database->cart->removeAllByUserId($user->id);

page_start('Ordine');
require(FRAGS_D . 'nav.php');
?>
	<main class="container-lg mt-nav text-center">
		<section>
			<div class="faded-container faded-right faded-left col-12 col-lg-7 mx-lg-auto">
				<img src="/assets/images/shipping.gif" alt="La spedizione verrà effettuata a breve" class="w-100" />
			</div>
			<h1 class="text-success display-1 display-lg-2">Ordine completato!</h1>
			<h2 class="display-4 text-muted mx-3">La spedizione verrà effettuata al più presto</h2>
		</section>
	</main>
	<section class="text-center mt-5">
		<a href="/" role="button" class="btn btn-success"><i class="bi-arrow-bar-left"></i> Torna alla homepage</a>
	</section>
<?php
page_end();
?>
