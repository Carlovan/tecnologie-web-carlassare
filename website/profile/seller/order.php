<?php
require_once('../../../config.php');
require_once(MAIN_DIR . 'utils.php');
require_once(BACKEND_D . 'database.php');
require_once(FRAGS_D . 'product_list.php');
require_once(FRAGS_D . 'page_delimiters.php');

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

page_start("Ordine in sospeso");
require(FRAGS_D . 'nav.php');
?>
	<main class="mt-nav container">
		<div class="col-lg-6 mx-lg-auto">
			<header class="mb-2">
				<h1 class="mb-0">Ordine <i class="fs-2">"<?= $order->id ?>"</i></h1>
				<span class="text-muted"><?= $order->formatDateTime() ?></span>
			</header>
			<section class="row g-0 justify-content-center">
				<h2>Prodotti venduti da te relativi a questo ordine:</h2>
				<?php foreach ($purchasedProducts as $p) { ?>
					<div class="card col-11 my-2">
						<div class="row g-0">
							<img src="<?= $p->getProduct()->imagePath ?>" alt="Immagine prodotto" class="col-3 object-fit-cover" />
							<div class="col ps-2 pe-3 py-1">
								<h3 class="mb-0"><?= $p->productName ?></h3>
								<p class="h5 my-0">€ <?= formatPrice($p->priceInCents) ?></p>
								<div class="d-flex align-items-center justify-content-between">
									<p class="mb-0">Quantità: <?= $p->quantity ?></p>
									<p class="mb-0">Totale: € <span class="fw-bold"><?= formatPrice($p->totalPriceInCents()) ?></span></p>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</section>
			<hr />
			<section class="pb-3 lead">
				<p class="mb-1 fw-bold">Indirizzo di spedizione:</p>
				<p><?= $order->shippingAddress ?> </p>
			</section>
		</div>
	</main>
	<section class="text-center">
		<a href="/api/confirm-order-shipped.php?id=<?= $order->id ?>" role="button" class="btn btn-success col-9 col-lg-2 mx-auto">Segna come spedito</a>
	</section>
<?php
page_end();
?>
