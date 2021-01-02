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

<div class="mt-nav"></div> <!-- Utile per aggiungere il margine iniziale -->

<?php
require(FRAGS_D . 'messages.php');
?>
	<main class="container">
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
			<a href="seller/new-product.php" role="button" class="col-6 btn btn-success">Aggiungi prodotto</a>
			<?php productListSeller($products); ?>
		</section>
	</main>
<?php
}
page_end();
?>
