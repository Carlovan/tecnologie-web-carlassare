<?php

function productList($products) {
	foreach ($products as $p) { ?>
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
	<?php }
}

function productListCart($products) {
	foreach ($products as $p) { ?>
		<div class="card col-11 my-2">
			<div class="row g-2 rounded text-reset text-decoration-none">
				<img src="<?= $p->imagePath ?>" alt="" class="col-3 rounded-start object-fit-cover"/>
				<div class="col py-2 pe-3">
					<div class="d-flex align-items-center">
						<h2 class="h3 mb-0"><?= $p->name ?></h2>
						<p class="mb-0 ms-2"><small class="text-muted"><?= $p->seller->name ?></small></p>
					</div>
					<div class="d-flex align-items-center align-items-end">
						<label for="quantity">Quantità: </label>
						<input id="quantity" name="quantity" type="number" min=1 inputmode="decimal" class="form-control w-25 ms-2 p-0 arrows-none text-center" value="<?= $p->quantity ?>"/>
						<button aria-label="Rimuovi" class="ms-auto border-0 bg-transparent p-0"><i class="bi bi-trash text-danger"></i></button>
					</div>
					<div class="d-flex align-items-center">
						<p class="h5 mb-0">€ <?= $p->formatPrice() ?></p>
						<p class="mb-0 ms-auto">Totale: € <span id="total-price fw-bold"><?= $p->formatPrice() ?></span></p>
					</div>
				</div>
			</div>
		</div>
	<?php }
}

function productListSeller($products) {
	foreach ($products as $p) { ?>
		<div class="card col-11 my-2">
			<a href="seller/edit-product.php?id=<?= $p->id ?>" class="row g-2 rounded text-reset text-decoration-none">
				<img src="<?= $p->imagePath ?>" alt="" class="col-4 rounded-start object-fit-cover"/>
				<div class="col pt-2">
					<h2 class="mb-0"><?= $p->name ?></h2>
					<p class="h5"><?= $p->formatPrice() ?> €</p>
				</div>
			</a>
		</div>
	<?php }
}
?>
