<?php
require_once('../../config.php');
require_once(BACKEND_D . 'types/user.php');
require_once(BACKEND_D . 'database.php');
require_once(FRAGS_D . 'page_delimiters.php');
require_once(FRAGS_D . 'product_list.php');

$user = new User();
$user->name = "{nome}";

$isNewSeller = false;

$db = new Database();
$products = $db->allProducts();

page_start('Profilo Venditore');
require(FRAGS_D . 'nav.php');
?>
	<main class="container mt-nav">
		<header>
			<h1>Profilo venditore per <?= $user->name ?></h1>
		</header>
		<section class="mt-4 row g-0">
			<form method="POST" class="col-10 m-auto">
				<label for="profilePic" class="form-label">Immagine di profilo:</label>
				<input id="profilePic" name="profilePic" type="file" accept="image/*" class="form-control" />
				<label for="name" class="form-label mt-2">Nome venditore:</label>
				<input id="name" name="name" type="text" required class="form-control" value="<?= $seller->name ?>"/>
				<label for="description" class="form-label mt-2">Descrizione:</label>
				<textarea id="description" name="description" rows="5" required class="form-control"><?= $seller->description ?></textarea> 
				<label for="website" class="form-label mt-2">Sito web:</label>
				<input id="website" name="website" type="url" required class="form-control" value="<?= $seller->website ?>"/>
				<?php if ($isNewSeller) { ?>
				<div class="text-center my-4">
					<input type="submit" formaction="/api/create_seller_profile.php" class="btn btn-success w-50 m-auto" value="Diventa venditore" />
				</div>
				<?php } else { ?>
				<div class="d-flex justify-content-center my-3">
					<input type="submit" form="form-remove" value="Rimuovi" class="btn btn-danger col-5 g-0 mx-2" />
					<input type="submit" formaction="/api/save_seller_profile.php" value="Salva modifiche" class="btn btn-success col-6 g-0 mx-2" />
				</div>
				<?php } ?>
			</form>
			<form id="form-remove" action="/api/remove_seller_profile.php" method="GET"></form>
		</section>
		<hr />
		<section class="row g-0 justify-content-center">
			<?php productListSeller($products); ?>
		</section>
	</main>
<?php
page_end();
?>
