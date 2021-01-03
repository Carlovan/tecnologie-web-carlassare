<?php

function productList($products) {
	foreach ($products as $p) { ?>
		<div class="card col-11 my-2">
			<a href="product.php?id=<?= $p->id ?>" class="row g-2 rounded text-reset text-decoration-none">
				<img src="<?= $p->imagePath ?>" alt="" class="col-4 rounded-start object-fit-cover"/>
				<div class="col pt-2">
					<h2 class="mb-0"><?= $p->name ?></h2>
					<p class="mt-0 mb-1"><small class="text-muted"><?= $p->getSeller()->name ?></small></p>
					<p class="h5"><?= $p->formatPrice() ?> €</p>
				</div>
			</a>
		</div>
	<?php }
}

?>
