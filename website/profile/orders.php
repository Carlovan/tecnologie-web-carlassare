<?php
require_once('../../config.php');
require_once(MAIN_DIR . 'utils.php');
require_once(FRAGS_D . 'page_delimiters.php');
require_once(BACKEND_D . 'database.php');

session_start();

$database = new Database();
$user = loggedUserOrRedirect($database);
$orders = $database->orders->byUserId($user->id);

page_start('Ordini');
require(FRAGS_D . 'nav.php');
?>
	<main class="container mt-nav">
		<header>
			<h1 class="text-lg-center">Ordini di <?= $user->name ?></h1>
		</header>
		<section class="row justify-content-center justify-content-lg-start">
		<?php if (empty($orders)) { ?>
			<h3 class="text-muted text-center">Non hai ordini</h3>
		<?php } else {
			foreach ($orders as $order) { ?>
				<div class="col-11 col-lg-4">
					<div class="card my-2 px-3 py-2">
						<a href="/profile/order.php?id=<?= $order->id ?>" class="text-reset text-decoration-none">
							<h5 class="mb-0">Ordine contenente <?= $order->getFirstProductName() ?></h5>
							<p class="my-0 text-muted"><small><?= $order->formatDateTime() ?></small></p>
							<div class="row">
								<p class="my-1 col-6">Totale: € <?= formatPrice($order->totalPriceInCents()) ?></p>
								<p class="my-1 col-6 text-end"><?= $order->totalObjects() ?> oggetti</p>
							</div>
						</a>
					</div>
				</div>
			<?php }
		} ?>
		</section>
	</main>
<?php
page_end();
?>
