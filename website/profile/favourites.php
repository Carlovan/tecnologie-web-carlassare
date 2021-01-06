<?php
require_once('../../config.php');
require_once(MAIN_DIR . 'utils.php');
require_once(BACKEND_D . 'database.php');
require_once(FRAGS_D . 'page_delimiters.php');

session_start();

$database = new Database();
$user = loggedUserOrRedirect($database);

$products = $database->favourites->byUserId($user->id);

page_start('Preferiti');
require(FRAGS_D . 'nav.php');
?>
	<main class="container mt-nav">
		<header>
			<h1 class="text-lg-center">Preferiti di <?= $user->name ?></h1>
		</header>
		<section class="row g-0 justify-content-center justify-content-lg-start">
			<?php if (empty($products)) { ?>
				<p class="h2 text-muted text-center">Non hai preferiti</p>
			<?php
			} else {
				foreach ($products as $p) { ?>
					<div class="col-11 col-lg-4">
						<div class="card my-2">
							<div class="row g-2">
								<div class="col">
									<a href="/product.php?id=<?= $p->id ?>" class="row g-2 text-reset text-decoration-none">
										<img src="<?= $p->imagePath ?>" alt="Immagine prodotto" class="col-4 rounded-start object-fit-cover"/>
										<div class="col pt-2">
											<h2 class="mb-0"><?= $p->name ?></h2>
											<p class="h5"><?= $p->formatPrice() ?> €</p>
										</div>
									</a>
								</div>
								<div class="col-1 me-2 pt-2">
									<button aria-label="Rimuovi" class="ms-auto border-0 bg-transparent p-0" onclick="removeFavourite('<?= $p->id ?>');"><i class="bi bi-trash text-danger"></i></button>
								</div>
							</div>
						</div>
					</div>
				<?php }
			} ?>
		</section>
	</main>
	<script>
		function removeFavourite(id) {
			window.location.href = '/api/remove-favourite.php?toUser=1&id=' + id;
		}
	</script>
<?php
page_end();
?>
