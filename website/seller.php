<?php
require_once('../config.php');
require_once(MAIN_DIR . 'utils.php');
require_once(BACKEND_D . 'database.php');
require_once(FRAGS_D . 'page_delimiters.php');
require_once(FRAGS_D . 'product_list.php');

if (is_null($_GET['id'])) {
	redirect('/');
}
$database = new Database();
$seller = $database->sellers->byUserId($_GET['id']);
if (is_null($seller)) {
	redirect('/');
}
$products = $database->products->bySellerId($seller->userId);

page_start($seller->name);
require(FRAGS_D . 'nav.php');
?>
	<main class="container mt-nav">
		<header>
			<div class="col-5 col-lg-3 float-start me-3">
				<img src="<?= $seller->imagePath ?>" alt="Immagine venditore" class="object-fit-cover rounded border w-100" />
			</div>
			<h1 class="h2 mt-lg-2"><?= $seller->name ?></h1>
			<?php if ($seller->website) { ?>
				<p><a href="<?= $seller->website ?>" class="text-decoration-none">Sito ufficiale <small class="bi bi-chevron-right align-top"></small></a></p>
			<?php } ?>
			<p>
				<?= $seller->description ?>
			</p>
		</header>
		<div class="clearfix"></div>
		<hr class="clearfix" />
		<section class="row justify-content-center justify-content-lg-start">
			<?php
				productList($products);
			?>
		</section>
	</main>
<?php
page_end();
?>

