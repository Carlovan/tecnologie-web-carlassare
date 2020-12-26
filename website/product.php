<?php
require_once('../config.php');
require_once('../backend/types/product.php');
require_once('../backend/database.php');
require_once('../fragments/page_delimiters.php');

$database = new Database();

$product = $database->getProduct($_GET['id']);

page_start($product->name);
require('../fragments/nav.php');
?>
	<main class="container">
		<header class="row">
			<img src="<?= $product->imagePath ?>" alt="" class="col-12 g-0"/>
		</header>
		<section class="row align-items-end mt-3">
			<div class="col">
				<h1 class="mb-0"><?= $product->name ?></h1>
				<p class="mt-0 mb-2"><small class="text-muted"><?= $product->seller->name ?></small></p>
				<p class="h5"><?= $product->formatPrice() ?> €</p>
			</div>
			<div class="col-2">
				<button id="add_favourite" aria-label="Aggiungi ai preferiti" class="btn btn-outline-danger rounded-circle py-2 text-center"><i class="bi bi-heart-fill"></i></button>
			</div>
		</section>
		<hr />
		<section>
			<p><span class="fw-bold">Categoria</span>: <?= implode('<small><i class="bi bi-chevron-right align-top"></i></small>', $product->category) ?></p>
			<h2>Descrizione</h2>
			<p><?= $product->description ?></p>
		</section>
	</main>
<?php
page_end();
?>
