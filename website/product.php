<?php
require('../backend/types/product.php');
require_once('../config.php');

$product = new Product("Babelfish", 10000);
?>

<!DOCTYPE html>
<html lang="it">
<head>
	<?php require('../fragments/metadata.php'); ?>
	<title><?= TITLE ?> - <?= $product->name ?></title>
</head>
<body>
	<?php require('../fragments/nav.php'); ?>
	<main>
		<header>
			<img src="<?= $product->imagePath ?>" alt="" />
		</header>
		<section>
			<h1><?= $product->name ?></h1>
			<p><?= $product->seller->name ?></p>
			<p><?= $product->formatPrice() ?> €</p>
			<button id="add_favourite">Cuore</button>
		</section>
		<section>
			<p>Categoria: <?= implode(' > ', $product->category) ?></p>
			<h2>Descrizione</h2>
			<p><?= $product->description ?></p>
		</section>
	</main>
</body>
</html>
