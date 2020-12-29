<?php
require_once('../../../config.php');
require_once(BACKEND_D . 'database.php');
require_once(FRAGS_D . 'page_delimiters.php');

$db = new Database();
$product = $db->getProduct($_GET['id']);

page_start('Modifica prodotto');
require(FRAGS_D . 'nav.php');
?>
	<main class="mt-nav container">
		<header>
			<h1>Modifica prodotto</h1>
		</header>
		<section class="mt-4">
			<form action="/api/editProduct.php" method="POST" class="col-10 m-auto">
				<label for="picture" class="form-label">Immagine:</label>
				<input id="picture" name="picture" type="file" accept="image/*" class="form-control" />
				<label for="name" class="form-label mt-2">Nome:</label>
				<input id="name" name="name" type="text" required value="<?= $product->name ?>" class="form-control"/>
				<label for="description" class="form-label mt-2">Descrizione:</label>
				<textarea id="description" name="description" rows="5" required class="form-control"><?= $product->description ?></textarea> 
				<label for="price" class="form-label mt-2">Prezzo:</label>
				<div class="input-group">
					<span class="input-group-text">€</span>
					<input id="price" name="price" type="number" required min="0.00" step="0.01" value="<?= $product->priceInCents / 100 ?>" class="form-control"/>
				</div>
				<label for="quantity" class="form-label mt-2">Quantità disponibile:</label>
				<input id="quantity" name="quantity" type="number" required min="0" value="<?= $product->quantity ?>" class="form-control"/>
				<label for="category" class="form-label">Categoria:</label>
				<select id="category" name="category" required class="form-select">
					<option>Cat1 &gt; Cat1.1</option>
					<option>Cat1 &gt; Cat1.2</option>
					<option>Cat2 &gt; Cat2.1</option>
				</select>
				<div class="text-center my-3">
					<input type="submit" class="btn btn-success w-50 m-auto" value="Salva" />
				</div>
			</form>
		</section>
	</main>
<?php
page_end();
?>
