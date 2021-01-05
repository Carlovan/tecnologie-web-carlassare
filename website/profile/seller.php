<?php
require_once('../../config.php');
require_once(MAIN_DIR . 'utils.php');
require_once(BACKEND_D . 'types/user.php');
require_once(BACKEND_D . 'database.php');
require_once(FRAGS_D . 'page_delimiters.php');
require_once(FRAGS_D . 'product_list.php');

session_start();

$database = new Database();
$user = loggedUserOrRedirect($database);
$seller = $database->sellers->byUserId($user->id);
$isSeller = !is_null($seller);

$products = array();
if ($isSeller) {
	$products = $database->products->bySellerId($seller->userId);
}

page_start('Profilo Venditore');
require(FRAGS_D . 'nav.php');
?>
	<main class="container mt-nav">
		<header>
			<h1>Profilo venditore per <?= $user->name ?></h1>
		</header>
		<section class="mt-4 row g-0">
			<form method="POST" enctype="multipart/form-data" class="col-10 m-auto">
				<?php if ($isSeller) { ?>
				<div class="text-center">
					<img src="<?= $seller->imagePath ?>" alt="Immagine venditore" class="w-50 img-thumbnail" />
				</div>
				<?php } ?>
				<label for="profilePic" class="form-label">Immagine di profilo:</label>
				<input id="profilePic" name="profilePic" type="file" <?php if (!$isSeller) { ?> required <?php } ?> accept="image/*" class="form-control" />
				<label for="name" class="form-label mt-2">Nome venditore:</label>
				<input id="name" name="name" type="text" required class="form-control" value="<?= $seller->name ?>"/>
				<label for="description" class="form-label mt-2">Descrizione:</label>
				<textarea id="description" name="description" rows="5" required class="form-control"><?= $seller->description ?></textarea> 
				<label for="website" class="form-label mt-2">Sito web:</label>
				<input id="website" name="website" type="url" class="form-control" value="<?= $seller->website ?>"/>
				<?php if ($isSeller) { ?>
				<div class="d-flex justify-content-center my-3">
					<input type="submit" form="form-remove" value="Rimuovi" class="btn btn-danger col-5 g-0 mx-2" />
					<input type="submit" formaction="/api/save-seller.php" value="Salva modifiche" class="btn btn-success col-6 g-0 mx-2" />
				</div>
				<?php } else { ?>
				<div class="text-center my-4">
					<input type="submit" formaction="/api/create-seller.php" class="btn btn-success w-50 m-auto" value="Diventa venditore" />
				</div>
				<?php } ?>
			</form>
			<form id="form-remove" action="/api/remove-seller.php" method="GET"></form>
		</section>
<?php
if ($isSeller) {
?>
		<hr />
		<section class="row g-0 justify-content-center mb-4">
			<div class="col-6">
				<a href="seller/new-product.php" role="button" class="btn btn-success">Aggiungi prodotto</a>
			</div>
			<div class="col-6">
				<a href="seller/orders.php" role="button" class="btn btn-success">Ordini in sospeso</a>
			</div>
			<?php foreach ($products as $p) { ?>
				<div class="card col-11 my-2">
					<div class="row g-2">
						<div class="col">
							<a href="seller/edit-product.php?id=<?= $p->id ?>" class="row g-2 text-reset text-decoration-none">
								<img src="<?= $p->imagePath ?>" alt="" class="col-4 rounded-start object-fit-cover"/>
								<div class="col pt-2">
									<h2 class="mb-0"><?= $p->name ?></h2>
									<p class="h5"><?= $p->formatPrice() ?> €</p>
								</div>
							</a>
						</div>
						<div class="col-1 me-2 pt-2">
							<button aria-label="Rimuovi" class="ms-auto border-0 bg-transparent p-0" onclick="removeProduct('<?= $p->id ?>');"><i class="bi bi-trash text-danger"></i></button>
						</div>
					</div>
				</div>
			<?php } ?>
		</section>
	</main>
	<script>
		function removeProduct(id) {
			window.location.href = '/api/remove-product.php?id=' + id;
		}
	</script>
<?php
}
page_end();
?>
