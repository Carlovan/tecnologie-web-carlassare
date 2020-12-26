<?php
require_once('../backend/database.php');
require_once('../fragments/page_delimiters.php');

page_start('Pagina principale');
require('../fragments/nav.php');
?>
	<main class="container mt-nav">
		<section class="row g-0 justify-content-center">
			<h1>Tutti i prodotti</h1>
			<?php
				$db = new Database();
				foreach ($db->allProducts() as $p) { ?>
					<div class="product-card card col-11 my-2">
						<a href="product.php?id=<?= $p->id ?>" class="row g-2 rounded text-reset text-decoration-none">
							<img style="" src="<?= $p->imagePath ?>" alt="" class="col-4 rounded-start product-img"/>
							<div class="col pt-2">
								<h2 class="product-title mb-0"><?= $p->name ?></h2>
								<p class="mt-0 mb-1"><small class="text-muted"><?= $p->seller->name ?></small></p>
								<p class="h5"><?= $p->formatPrice() ?> €</p>
							</div>
						</a>
					</div>
				<?php }
			?>
		</section>
		<section>
			<h1>Ultimi aggiunti</h1>
		</section>
		<section>
			<h1>Più venduti</h1>
		</section>
	</main>
<?php
page_end();
?>
