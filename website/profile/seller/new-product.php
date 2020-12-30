<?php
require_once('../../../config.php');
require_once(BACKEND_D . 'database.php');
require_once(FRAGS_D . 'page_delimiters.php');

session_start();

page_start('Aggiungi prodotto');
require(FRAGS_D . 'nav.php');
?>

<div class="mt-nav"></div> <!-- Utile per aggiungere il margine iniziale -->

<?php
if (isset($_SESSION['err'])) { ?>
	<div class="alert alert-danger mx-3" role="alert">
		<b>Si è verificato un errore: </b><?= $_SESSION['err'] ?>
	</div>
<?php
	unset($_SESSION['err']);
}

if (isset($_SESSION['info'])) { ?>
	<div class="alert alert-success mx-3" role="alert">
		<?= $_SESSION['info'] ?>
	</div>
<?php
	unset($_SESSION['info']);
}
?>
	<main class="container">
		<header>
			<h1>Aggiungi prodotto</h1>
		</header>
		<section class="mt-4">
			<form action="/api/create-product.php" method="POST" class="col-10 m-auto">
				<label for="picture" class="form-label">Immagine:</label>
				<input id="picture" name="picture" type="file" accept="image/*" class="form-control" />
				<label for="name" class="form-label mt-2">Nome:</label>
				<input id="name" name="name" type="text" required class="form-control"/>
				<label for="description" class="form-label mt-2">Descrizione:</label>
				<textarea id="description" name="description" rows="5" required class="form-control"></textarea> 
				<label for="price" class="form-label mt-2">Prezzo:</label>
				<div class="input-group">
					<span class="input-group-text">€</span>
					<input id="price" name="price" type="number" required min="0.01" step="0.01" class="form-control"/>
				</div>
				<label for="quantity" class="form-label mt-2">Quantità disponibile:</label>
				<input id="quantity" name="quantity" type="number" required min="0" class="form-control"/>
				<label for="category" class="form-label">Categoria:</label>
				<select id="category" name="category" required class="form-select">
					<option>Cat1 &gt; Cat1.1</option>
					<option>Cat1 &gt; Cat1.2</option>
					<option>Cat2 &gt; Cat2.1</option>
				</select>
				<div class="text-center my-3">
					<input type="submit" class="btn btn-success w-50 m-auto" value="Crea" />
				</div>
			</form>
		</section>
	</main>
<?php
page_end();
?>
