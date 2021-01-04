<?php
require_once('../config.php');
require_once(MAIN_DIR . 'utils.php');
require_once(BACKEND_D . 'database.php');
require_once(FRAGS_D . 'product_list.php');
require_once(FRAGS_D . 'page_delimiters.php');

session_start();

$database = new Database();
$user = loggedUserOrRedirect($database);

$entries = $database->cart->byUserId($user->id);

$totalPrice = 0;
$totalObjects = 0;
foreach ($entries as $e) {
	$totalPrice += $e->totalPrice();
	$totalObjects += $e->quantity;
}


page_start("Carrello");
require(FRAGS_D . 'nav.php');
?>
	<div class="mt-nav"></div>
<?php
require(FRAGS_D . 'messages.php');
?>
	<main class="container">
		<header>
			<h1>Il tuo carrello</h1>
		</header>
		<?php if ($totalObjects > 0) { ?>
		<section class="row g-0 justify-content-center">
			<?php foreach ($entries as $e) { ?>
				<div class="card col-11 my-2">
					<div class="row g-2 rounded text-reset text-decoration-none">
						<img src="<?= $e->getProduct()->imagePath ?>" alt="Immagine prodotto" class="col-3 rounded-start object-fit-cover"/>
						<div class="col py-2 pe-3">
							<div class="d-flex align-items-center">
								<h2 class="h3 mb-0"><?= $e->getProduct()->name ?></h2>
								<p class="mb-0 ms-2"><small class="text-muted"><?= $e->getProduct()->getSeller()->name ?></small></p>
							</div>
							<div class="d-flex align-items-center align-items-end">
								<label for="quantity">Quantità: </label>
								<input id="quantity" name="quantity" type="number" min=1 inputmode="decimal" class="form-control w-25 ms-2 p-0 arrows-none text-center" value="<?= $e->quantity ?>"/>
								<button aria-label="Rimuovi" class="ms-auto border-0 bg-transparent p-0" onclick="removeFromCart('<?= $e->productId ?>');"><i class="bi bi-trash text-danger"></i></button>
							</div>
							<div class="d-flex align-items-center">
								<p class="h5 mb-0">€ <?= $e->getProduct()->formatPrice() ?></p>
								<p class="mb-0 ms-auto">Totale: € <span id="total-price fw-bold"><?= formatPrice($e->totalPrice()) ?></span></p>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		</section>
		<hr />
		<section class="pb-3">
			<p class="mb-1">Totale (<?= $totalObjects ?> oggetti): € <?= formatPrice($totalPrice) ?></p>
			<p><span class="text-success">Spedizione gratuita</span> verso <?= $user->shippingAddress->format() ?></p>
			<a href="/order-complete.php" role="button" class="btn btn-success w-100 m-auto">Conferma e paga</a>
		</section>
		<?php } else { ?>
		<section>
			<p class="h2 text-muted text-center">Il tuo carrello è vuoto</p>
		</section>
		<?php } ?>
	</main>
	<script>
		function removeFromCart(id) {
			window.location.href = '/api/remove-cart-product.php?id=' + id;
		}
	</script>
<?php
page_end();
?>

