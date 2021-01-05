<?php
require_once('../../../config.php');
require_once(MAIN_DIR . 'utils.php');
require_once(FRAGS_D . 'page_delimiters.php');
require_once(BACKEND_D . 'database.php');

session_start();

$database = new Database();
$user = loggedUserOrRedirect($database);
if (is_null($database->sellers->byUserId($user->id))) {
	redirect('/profile/seller.php');
}
$orders = $database->orders->bySellerId($user->id);

page_start('Ordini in sospeso');
require(FRAGS_D . 'nav.php');
?>
	<main class="container mt-nav">
		<header>
			<h1>Ordini in sospeso</h1>
		</header>
		<section class="row justify-content-center">
		<?php if (empty($orders)) { ?>
			<h3 class="text-muted text-center">Non hai ordini in sospeso</h3>
		<?php } else {
			foreach ($orders as $order) { ?>
				<div class="card col-11 my-2 px-3 py-2">
					<a href="/profile/seller/order.php?id=<?= $order->id ?>" class="text-reset text-decoration-none">
						<h5 class="mb-0">Ordine contenente <?= $order->getFirstProductName() ?></h5>
						<p class="my-0 text-muted"><small><?= $order->formatDateTime() ?></small></p>
						<div class="row">
							<p class="my-1 col-6">Totale: € <?= formatPrice($order->totalPriceInCents()) ?></p>
							<p class="my-1 col-6 text-end"><?= $order->totalObjects() ?> oggetti</p>
						</div>
					</a>
				</div>
			<?php }
		} ?>
		</section>
	</main>
<?php
page_end();
?>
