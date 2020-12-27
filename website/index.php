<?php
require_once('../config.php');
require_once(BACKEND_D . 'database.php');
require_once(FRAGS_D . 'page_delimiters.php');
require_once(FRAGS_D . 'product_list.php');

$database = new Database();

page_start('Pagina principale');
require('../fragments/nav.php');
?>
	<main class="container mt-nav">
		<section class="row g-0 justify-content-center">
			<h1>Tutti i prodotti</h1>
			<?php productList($database->allProducts()); ?>
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
