<?php
require_once('../config.php');
require_once(BACKEND_D . 'database.php');
require_once(FRAGS_D . 'page_delimiters.php');
require_once(FRAGS_D . 'product_list.php');

$database = new Database();

page_start('Pagina principale');
require(FRAGS_D . 'nav.php');
?>
	<main class="container mt-nav">
		<section class="row justify-content-center">
			<h1>Ultimi aggiunti</h1>
			<?php productList($database->products->lastAdded()); ?>
		</section>
		<section class="row justify-content-center">
			<h1>Più venduti</h1>
			<?php productList($database->products->mostSold()); ?>
		</section>
	</main>
<?php
page_end();
?>
