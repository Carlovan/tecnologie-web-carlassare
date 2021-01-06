<?php
require_once('../../../config.php');
require_once(MAIN_DIR . 'utils.php');
require_once(BACKEND_D . 'database.php');
require_once(FRAGS_D . 'page_delimiters.php');

session_start();

$database = new Database();
$user = loggedUserOrRedirect($database);
$seller = $database->sellers->byUserId($user->id);
$product = $database->products->get($_GET['id']);
$categories = $database->categories->all();

if (is_null($seller)) {
	redirect('/profile.php');
}
if (is_null($product) || $product->sellerId !== $seller->userId) {
	redirect('/profile/seller.php');
}

page_start('Modifica prodotto');
require(FRAGS_D . 'nav.php');
?>
	<main class="container mt-nav">
		<header>
			<h1 class="text-md-center">Modifica prodotto</h1>
		</header>
		<section class="mt-4 d-lg-flex">
			<div class="text-center col-lg-3">
				<img src="<?= $product->imagePath ?>" alt="Immagine prodotto" class="col-6 col-lg-11 img-thumbnail" />
			</div>
			<form action="/api/save-product.php" method="POST" enctype="multipart/form-data" class="col-10 col-lg m-auto">
				<label for="picture" class="form-label">Immagine:</label>
				<input id="picture" name="picture" type="file" accept="image/*" class="form-control" />
				<label for="name" class="form-label mt-2">Nome:</label>
				<input id="name" name="name" type="text" required value="<?= $product->name ?>" class="form-control"/>
				<label for="description" class="form-label mt-2">Descrizione:</label>
				<textarea id="description" name="description" rows="5" required class="form-control"><?= $product->description ?></textarea> 
				<label for="price" class="form-label mt-2">Prezzo:</label>
				<div class="input-group">
					<span class="input-group-text">€</span>
					<input id="price" name="price" type="number" required min="0.01" step="0.01" value="<?= $product->formatPrice() ?>" class="form-control"/>
				</div>
				<label for="quantity" class="form-label mt-2">Quantità disponibile:</label>
				<input id="quantity" name="quantity" type="number" required min="0" value="<?= $product->quantity ?>" class="form-control"/>
				<p class="text-muted">Il prodotto è stato acquistato <?= $product->soldCount ?> volte</p>
				<label for="category" class="form-label">Categoria:</label>
				<select id="category" name="category" required class="form-select">
					<option></option>
					<?php foreach ($categories as $name => $path) { ?>
						<option value="<?= $name ?>" <?= $product->category === $name ? 'selected' : '' ?> ><?= implode(' &gt; ', $path) ?></option>
					<?php } ?>
				</select>
				<div class="text-center my-3">
					<input type="submit" class="btn btn-success col-6 col-lg-3 m-auto" value="Salva" />
				</div>
				<input type="hidden" name="productId" value="<?= $product->id ?>" />
			</form>
		</section>
	</main>
<?php
page_end();
?>
