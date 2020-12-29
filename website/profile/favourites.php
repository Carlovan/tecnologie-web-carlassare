<?php
require_once('../../config.php');
require_once(FRAGS_D . 'page_delimiters.php');

page_start('Preferiti');
require(FRAGS_D . 'nav.php');
?>
	<main>
		<header>
			<h1>Preferiti di <?= $user->name ?></h1>
		</header>
		<section>
			<?php foreach ($orders as $order) { ?>
				<div class="card col-11 my-2">
					<a href="product.php?id=<?= $p->id ?>" class="row g-2 rounded text-reset text-decoration-none">
						<img src="<?= $p->imagePath ?>" alt="" class="col-4 rounded-start object-fit-cover"/>
						<div class="col pt-2">
							<h2 class="mb-0"><?= $p->name ?></h2>
							<p class="mt-0 mb-1"><small class="text-muted"><?= $p->seller->name ?></small></p>
							<p class="h5"><?= $p->formatPrice() ?> €</p>
						</div>
					</a>
				</div>
			<?php } ?>
		</section>
	</main>
<?php
page_end();
?>
