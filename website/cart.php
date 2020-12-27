<?php
require_once('../config.php');
require_once(BACKEND_D . 'database.php');
require_once(FRAGS_D . 'product_list.php');
require_once(FRAGS_D . 'page_delimiters.php');


$database = new Database();

$cartProducts = $database->getCartProducts();

page_start("Carrello");
require(FRAGS_D . 'nav.php');
?>
	<main class="container mt-nav">
		<header>
			<h1>Il tuo carrello</h1>
		</header>
		<section class="row g-0 justify-content-center">
			<?php productListCart($cartProducts); ?>
		</section>
		<hr />
		<section class="pb-3">
			<p class="mb-1">Totale (<?= count($cartProducts) ?> oggetti): € <?= 'X' ?></p>
			<p><span class="text-success">Spedizione gratuita</span> verso <?= $user->address ?></p>
			<button class="btn btn-success w-100 m-auto">Conferma e paga</button>
		</section>
	</main>
<?php
page_end();
?>

