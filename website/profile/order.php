<?php
require_once('../../config.php');
require_once(MAIN_DIR . 'utils.php');
require_once(BACKEND_D . 'database.php');
require_once(FRAGS_D . 'product_list.php');
require_once(FRAGS_D . 'page_delimiters.php');

session_start();

$database = new Database();
$user = loggedUserOrRedirect($database);

$order = $database->orders->get($_GET['id']);
if (is_null($order)) {
	redirect('/profile/orders.php');
}


page_start("Ordine");
require(FRAGS_D . 'nav.php');
?>
	<main class="mt-nav container">
		<header class="mb-2">
			<h1 class="mb-0">Ordine <i class="fs-2">"<?= $order->id ?>"</i></h1>
			<span class="text-muted"><?= $order->formatDateTime() ?></span>
		</header>
		<section class="row g-0 justify-content-center">
			<h2>Prodotti relativi a questo ordine:</h2>
			<?php foreach ($order->getProducts() as $p) {
				if (is_null($p->productId)) {
					$anchorAttributes = 'href="#" onclick="showModal();"';
					$imagePath = '/assets/images/placeholder.png';
				} else {
					$anchorAttributes = 'href="/product.php?id=' . $p->productId . '"';
					$imagePath = $p->getProduct()->imagePath;
				} ?>
				<div class="card col-11 my-2">
					<a <?= $anchorAttributes ?> class="row g-0 text-reset text-decoration-none position-relative">
						<?php if ($p->shipped) { ?>
							<div class="badge rounded-circle bg-success position-absolute top-0 start-0 m-2 col-1 w-small p-1">
								<img src='/assets/icons/truck.svg' alt="Spedito" title="Spedito" class="w-100" />
							</div>
						<?php } ?>
						<img src="<?= $imagePath ?>" alt="Immagine prodotto" class="col-3 object-fit-cover" />
						<div class="col ps-2 pe-3 py-1">
							<h3 class="mb-0"><?= $p->productName ?></h3>
							<p class="mb-0"><small class="text-muted"><?= $p->sellerName ?></small></p>
							<p class="h5 my-0">€ <?= formatPrice($p->priceInCents) ?></p>
							<div class="d-flex align-items-center justify-content-between">
								<p class="mb-0">Quantità: <?= $p->quantity ?></p>
								<p class="mb-0">Totale: € <span id="total-price fw-bold"><?= formatPrice($p->totalPriceInCents()) ?></span></p>
							</div>
						</div>
					</a>
				</div>
			<?php } ?>
		</section>
		<hr />
		<section class="pb-3 lead">
			<p class="mb-1">Totale (<?= $order->totalObjects() ?> oggetti): € <?= formatPrice($order->totalPriceInCents()) ?></p>
		</section>
	</main>
	<script>
		function showModal() {
			alert("Questo prodotto non è più disponibile");
		}
	</script>
<?php
page_end();
?>
