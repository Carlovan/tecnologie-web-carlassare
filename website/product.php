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
	<div class="mt-nav"></div>
<?php
require(FRAGS_D . 'messages.php');
?>
	<main class="container product-page">
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
			<?php if ($isLogged) { ?>
				<?php if ($isFavourite) { ?>
					<button id="remove-favourite" aria-label="Rimuovi dai preferiti" onclick="removeFavourite();" class="btn btn-outline-danger rounded-circle py-2 text-center">
						<i class="bi bi-heart-fill"></i>
					</button>
				<?php } else { ?>
					<button id="add-favourite" aria-label="Aggiungi ai preferiti" onclick="addFavourite();" class="btn btn-outline-danger rounded-circle py-2 text-center">
						<i class="bi bi-heart"></i>
					</button>
				<?php } ?>
			<?php } else { ?>
					<button id="favourite" aria-label="Aggiungi ai preferiti" disabled class="btn btn-outline-secondary rounded-circle py-2 text-center">
						<i class="bi bi-heart-fill"></i>
					</button>
			<?php } ?>
			</div>
		</section>
		<hr />
		<section class="mb-5">
			<p><span class="fw-bold">Categoria</span>: <?= implode('<small><i class="bi bi-chevron-right align-top"></i></small>', $product->category) ?></p>
			<h2>Descrizione</h2>
			<p><?= $product->description ?></p>
		</section>
		<footer class="fixed-bottom p-2">
			<button class="btn btn-success w-100" <?= $isLogged ? "onclick='addCart();'" : "disabled" ?> >Aggiungi al carrello</button>
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
