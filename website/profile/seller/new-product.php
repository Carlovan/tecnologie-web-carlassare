<?php
require_once('../../../config.php');
require_once(BACKEND_D . 'database.php');
require_once(FRAGS_D . 'page_delimiters.php');

session_start();
$database = new Database();
$categories = $database->categories->all();

page_start('Aggiungi prodotto');
require(FRAGS_D . 'nav.php');
?>
	<main class="container mt-nav">
		<header>
			<h1 class="text-lg-center">Aggiungi prodotto</h1>
		</header>
		<section class="mt-4">
			<form action="/api/create-product.php" method="POST" enctype="multipart/form-data" class="col-11 m-auto row justify-content-lg-around">
				<div class="col-lg-4">
					<label for="picture" class="form-label">Immagine:</label>
					<input id="picture" name="picture" type="file" accept="image/*" class="form-control" />
				</div>
				<div class="col-lg-5 mt-2 mt-lg-0">
					<label for="name" class="form-label">Nome:</label>
					<input id="name" name="name" type="text" required class="form-control"/>
				</div>
				<div class="col-lg-11 mt-2">
					<label for="description" class="form-label">Descrizione:</label>
					<textarea id="description" name="description" rows="5" required class="form-control"></textarea> 
				</div>
				<div class="col-lg-3 mt-2 pe-lg-5">
					<label for="price" class="form-label">Prezzo:</label>
					<div class="input-group">
						<span class="input-group-text">€</span>
						<input id="price" name="price" type="number" required min="0.01" step="0.01" class="form-control"/>
					</div>
				</div>
				<div class="col-lg-3 mt-2 px-lg-5">
					<label for="quantity" class="form-label">Quantità disponibile:</label>
					<input id="quantity" name="quantity" type="number" required min="0" class="form-control"/>
				</div>
				<div class="col-lg-3 mt-2">
					<label for="category" class="form-label">Categoria:</label>
					<select id="category" name="category" required class="form-select">
						<option>Scegli categoria...</option>
						<?php foreach ($categories as $name => $path) { ?>
							<option value="<?= $name ?>"><?= implode(' &gt; ', $path) ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="text-center my-3">
					<input type="submit" class="btn btn-success col-6 col-lg-3 m-auto" value="Crea" />
				</div>
			</form>
		</section>
	</main>
<?php
page_end();
?>
