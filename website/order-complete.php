<?php
require_once('../config.php');
require_once(MAIN_DIR . 'utils.php');
require_once(FRAGS_D . 'page_delimiters.php');
require_once(BACKEND_D . 'database.php');
require_once(BACKEND_D . 'types/order.php');
require_once(BACKEND_D . 'types/purchased-product.php');

session_start();

$database = new Database();
$user = loggedUserOrRedirect($database);

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
}

$database->cart->removeAllByUserId($user->id);

page_start('Ordine');
require(FRAGS_D . 'nav.php');
?>
	<main class="mt-nav text-center">
		<section>
			<img src="/assets/images/shipping.gif" alt="La spedizione verrà effettuata a breve" class="w-100" />
			<h1 class="text-success display-1">Ordine completato!</h1>
			<h2 class="display-4 text-muted mx-3">La spedizione verrà effettuata al più presto</h2>
		</section>
	</main>
	<section class="text-center mt-5">
		<a href="/" role="button" class="btn btn-success"><i class="bi-arrow-bar-left"></i> Torna alla homepage</a>
	</section>
<?php
page_end();
?>
