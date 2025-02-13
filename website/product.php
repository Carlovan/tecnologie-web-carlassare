<?php
require_once('../config.php');
require_once(MAIN_DIR . 'utils.php');
require_once(BACKEND_D . 'types/product.php');
require_once(BACKEND_D . 'database.php');
require_once(FRAGS_D . 'page_delimiters.php');

session_start();

$database = new Database();
$user = loggedUser($database);

$product = $database->products->get($_GET['id']);
if (is_null($product)) {
	redirect('/');
}
$isLogged = !is_null($user);
$isFavourite = $isLogged && $product->isFavourite($user);

page_start($product->name);
require('../fragments/nav.php');
?>
	<main class="container px-0 mt-nav d-lg-flex">
		<header class="col-lg-4">
			<div class="position-relative col-12 g-0 max-vh-50">
				<img src="<?= $product->imagePath ?>" alt="Immagine prodotto" class="w-100 object-fit-cover"/>
				<?php if ($product->checkFreeQuantity() <= 0) { ?>
				<span class="badge rounded-pill bg-danger position-absolute top-0 start-0 m-3">Non disponibile</span>
				<?php } ?>
			</div>
			<div class="d-none d-lg-block text-center mt-4">
				<button class="btn btn-success w-75 mx-auto" <?= $isLogged && $product->checkFreeQuantity() > 0 ? "onclick='addCart();'" : "disabled" ?> >Aggiungi al carrello</button>
			</div>
		</header>
		<div class="px-3 ms-lg-5 col-lg">
			<section class="row align-items-end mt-3">
				<div class="col">
					<h1 class="mb-0"><?= $product->name ?></h1>
					<a href="/seller.php?id=<?= $product->getSeller()->userId ?>" class="mt-0 mb-2 text-reset text-decoration-none"><small class="text-muted"><?= $product->getSeller()->name ?></small></a>
					<p class="h5"><?= $product->formatPrice() ?> €</p>
				</div>
				<div class="col-2">
				<?php if ($isLogged) { ?>
					<?php if ($isFavourite) { ?>
						<button id="remove-favourite" aria-label="Rimuovi dai preferiti" onclick="removeFavourite();" class="btn btn-outline-danger rounded-circle py-2 text-center">
							<span class="bi bi-heart-fill"></span>
						</button>
					<?php } else { ?>
						<button id="add-favourite" aria-label="Aggiungi ai preferiti" onclick="addFavourite();" class="btn btn-outline-danger rounded-circle py-2 text-center">
							<span class="bi bi-heart"></span>
						</button>
					<?php } ?>
				<?php } else { ?>
						<button id="favourite" aria-label="Aggiungi ai preferiti" disabled class="btn btn-outline-secondary rounded-circle py-2 text-center">
							<span class="bi bi-heart-fill"></span>
						</button>
				<?php } ?>
				</div>
			</section>
			<hr />
			<section class="mb-5">
				<p><span class="fw-bold">Categoria</span>: <?= implode('<small><span class="bi bi-chevron-right align-top"></span></small>', $product->getCategory()) ?></p>
				<h2>Descrizione</h2>
				<p><?= $product->description ?></p>
			</section>
		</div>
		<footer class="fixed-bottom p-2 d-lg-none">
			<button class="btn btn-success w-100" <?= $isLogged && $product->checkFreeQuantity() > 0 ? "onclick='addCart();'" : "disabled" ?> >Aggiungi al carrello</button>
		</footer>
	</main>
	<?php if ($isLogged) { ?>
	<script>
		function addFavourite() {
			window.location.href = '/api/add-favourite.php?id=<?= $product->id ?>';
		}
		function removeFavourite() {
			window.location.href = '/api/remove-favourite.php?id=<?= $product->id ?>';
		}
		function addCart() {
			window.location.href = '/api/add-cart-product.php?id=<?= $product->id ?>';
		}
	</script>
	<?php } ?>
<?php
page_end();
?>
