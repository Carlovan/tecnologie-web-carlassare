<?php
require_once('../config.php');
require_once('../backend/database.php');
require_once('../fragments/product_list.php');
require_once('../fragments/page_delimiters.php');

$database = new Database();

$cartProducts = $database->getCartProducts();

page_start("Carrello");
require('../fragments/nav.php');
?>
	<main class="container mt-nav">
		<header>
			<h1>Il tuo carrello</h1>
		</header>
		<section class="row g-0 justify-content-center">
			<?php productListCart($cartProducts); ?>
		</section>
		<hr />
		<section>
			<p>Totale (<?= count($cartProducts) ?>): € <?= ?></p>
			<p><span class="text-success">Spedizione gratuita</span> verso <?= $user->address ?></p>
			<button class="btn btn-success">Conferma e paga</button>
		</section>
	</main>
<?php
page_end();
?>

