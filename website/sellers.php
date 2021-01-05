<?php
require_once('../config.php');
require_once(BACKEND_D . 'database.php');
require_once(FRAGS_D . 'page_delimiters.php');

$database = new Database();
$sellers = $database->sellers->all();

page_start('Venditori');
require(FRAGS_D . 'nav.php');
?>
	<main class="container mt-nav">
		<section class="row justify-content-center justify-content-lg-start">
			<h1 class="text-lg-center">Tutti i venditori</h1>
			<?php foreach ($sellers as $s) { ?>
				<div class="col-11 col-lg-4">
					<div class="card my-2">
						<a href="/seller.php?id=<?= $s->userId ?>" class="row g-2 rounded text-reset text-decoration-none">
							<img src="<?= $s->imagePath ?>" alt="Immagine venditore" class="col-4 rounded-start object-fit-cover"/>
							<div class="col mt-3">
								<h2 class="mb-0"><?= $s->name ?></h2>
							</div>
						</a>
					</div>
				</div>
			<?php } ?>
		</section>
	</main>
<?php
page_end();
?>
