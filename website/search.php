<?php
require_once('../config.php');
require_once(BACKEND_D . 'database.php');
require_once(FRAGS_D . 'page_delimiters.php');
require_once(FRAGS_D . 'product_list.php');

$database = new Database();
$query = $_GET['q'];
$words = preg_split('/\s+/', trim($query));
$products = $database->products->search($words);

page_start('Ricerca');
require(FRAGS_D . 'nav.php');
?>
	<main class="container mt-nav">
		<section class="row justify-content-center justify-content-lg-start">
			<h1 class="text-lg-center">Ricerca</h1>
			<h2 class="text-muted h4">Risultati per la ricerca: <i>"<?= implode(' ', $words) ?>"</i></h2>
			<?php productList($products); ?>
		</section>
	</main>
<?php
page_end();
?>
