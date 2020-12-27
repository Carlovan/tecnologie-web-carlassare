<?php
require_once('../config.php');
require_once(BACKEND_D . 'database.php');
require_once(FRAGS_D . 'page_delimiters.php');
require_once(FRAGS_D . 'product_list.php');

$database = new Database();
$seller = $database->getSeller($_GET['id']);
$products = $database->allProducts();

page_start($seller->name);
require(FRAGS_D . 'nav.php');
?>
	<main class="container mt-nav">
		<header>
			<div class="col-5 float-start me-3">
				<img src="<?= $seller->imagePath ?>" alt="" class="object-fit-cover rounded border w-100" />
			</div>
			<h1 class="h2"><?= $seller->name ?></h1>
			<?php if ($seller->website) { ?>
				<p><a href="<?= $seller->website ?>" class="text-decoration-none">Sito ufficiale <small class="bi bi-chevron-right align-top"></small></a></p>
			<?php } ?>
			<p>
				<?= $seller->description ?>
			</p>
		</header>
		<hr class="clearfix" />
		<section class="row g-0 justify-content-center">
			<?php
				productList($products);
			?>
		</section>
	</main>
<?php
page_end();
?>

