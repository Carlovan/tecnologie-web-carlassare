<?php
require_once('../config.php');
require_once(BACKEND_D . 'types/product.php');
require_once(BACKEND_D . 'database.php');
require_once(FRAGS_D . 'page_delimiters.php');

$database = new Database();

$product = $database->products->get($_GET['id']);

page_start($product->name);
require('../fragments/nav.php');
?>
	<main class="container product-page mt-nav">
		<header class="row">
			<img src="<?= $product->imagePath ?>" alt="" class="col-12 g-0 max-vh-50 object-fit-cover"/>
		</header>
		<section class="row align-items-end mt-3">
			<div class="col">
				<h1 class="mb-0"><?= $product->name ?></h1>
				<p class="mt-0 mb-2"><small class="text-muted"><?= $product->getSeller()->name ?></small></p>
				<p class="h5"><?= $product->formatPrice() ?> €</p>
			</div>
			<div class="col-2">
				<button id="add-favourite" aria-label="Aggiungi ai preferiti" class="btn btn-outline-danger rounded-circle py-2 text-center"><i class="bi bi-heart-fill"></i></button>
			</div>
		</section>
		<hr />
		<section class="mb-5">
			<p><span class="fw-bold">Categoria</span>: <?= implode('<small><i class="bi bi-chevron-right align-top"></i></small>', $product->category) ?></p>
			<h2>Descrizione</h2>
			<p><?= $product->description ?></p>
		</section>
		<footer class="fixed-bottom p-2">
			<button class="btn btn-success w-100">Aggiungi al carrello</button>
		</footer>
	</main>
<?php
page_end();
?>
