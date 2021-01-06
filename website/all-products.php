<?php
require_once('../config.php');
require_once(BACKEND_D . 'database.php');
require_once(FRAGS_D . 'page_delimiters.php');
require_once(FRAGS_D . 'product_list.php');

$database = new Database();
$categories = $database->categories->all();
$current = "";
$subcat = array_key_exists('subcat', $_GET);
if (isset($_GET['category']) && array_key_exists($_GET['category'], $categories)) {
	$current = $_GET['category'];
}

if (empty($current)) {
	$products = $database->products->all();
} else {
	if ($subcat) {
		$searchCategories = array_keys(array_filter($categories, function($path) use ($current) { return in_array($current, $path); }));
	} else {
		$searchCategories = [$current];
	}
	$products = $database->products->byCategories($searchCategories);
}

page_start('Tutti i prodotti');
require(FRAGS_D . 'nav.php');
?>
	<main class="container mt-nav">
		<section class="row justify-content-center justify-content-lg-start">
			<h1>Tutti i prodotti</h1>
			<form id="category-form" class="row" action="">
				<label for="category" class="col-6 col-lg-2 col-form-label">Filtra per categoria:</label>
				<div class="col-6 col-lg-3">
					<select id="category" name="category" class="form-select">
						<option value="" <?= $current === "" ? 'selected' : '' ?>></option>
						<?php foreach ($categories as $name => $path) { ?>
							<option value="<?= $name ?>" <?= $current === $name ? 'selected' : '' ?> ><?= implode(' &gt; ', $path) ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-12 col-lg-3 align-self-center text-end text-lg-start my-2 my-lg-0">
					<input type="checkbox" id="subcat" name="subcat" class="form-check-input" <?= $subcat ? 'checked' : ''?> />
					<label for="subcat" class="form-check-label">Includi sottocategorie</label>
				</div>
			</form>
			<?php if (empty($products)) { ?>
				<h3 class="text-muted text-center">Nessun risultato</h3>
			<?php } else {
				productList($products);
			} ?>
		</section>
	</main>
	<script>
		function filterCategory() {
			if ($('#category').val()) {
				$('#category-form').submit();
			}
		}

		$('#category-form input, #category-form select').on('change', filterCategory);
	</script>
<?php
page_end();
?>
