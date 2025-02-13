<?php
require_once('../config.php');
require_once(MAIN_DIR . 'utils.php');
require_once(FRAGS_D . 'page_delimiters.php');
require_once(BACKEND_D . 'database.php');

session_start();

$database = new Database();
$user = loggedUserOrRedirect($database);

page_start('Profilo');
require(FRAGS_D . 'nav.php');
?>
	<main class="container mt-nav">
		<h1 class="text-lg-center">Benvenuto, <?= $user->name ?></h1>
		<section class="row mt-5">
			<div class="col-12 col-lg-4 mb-3">
				<a href="/profile/personaldata.php" class="card text-decoration-none text-reset">
					<div class="card-body d-flex justify-content-center fw-bold">
						<span class="bi bi-person-circle text-warning lh-sm"></span><div class="col-5 text-center">Dati personali</div>
					</div>
				</a>
			</div>
			<div class="col-12 col-lg-4 mb-3">
				<a href="/profile/address.php" class="card text-decoration-none text-reset">
					<div class="card-body d-flex justify-content-center fw-bold">
						<span class="bi bi-house-fill text-primary lh-sm"></span><div class="col-5 text-center">Indirizzo</div>
					</div>
				</a>
			</div>
			<div class="col-12 col-lg-4 mb-3">
				<a href="/profile/orders.php" class="card text-decoration-none text-reset">
					<div class="card-body d-flex justify-content-center fw-bold">
						<span class="bi bi-truck text-success lh-sm"></span><div class="col-5 text-center">Ordini</div>
					</div>
				</a>
			</div>
			<div class="col-12 col-lg-4 mb-3">
				<a href="/profile/favourites.php" class="card text-decoration-none text-reset">
					<div class="card-body d-flex justify-content-center fw-bold">
						<span class="bi bi-heart-fill text-danger lh-sm"></span><div class="col-5 text-center">Preferiti</div>
					</div>
				</a>
			</div>
			<div class="col-12 col-lg-4 mb-3">
				<a href="/profile/seller.php" class="card text-decoration-none text-reset">
					<div class="card-body d-flex justify-content-center fw-bold">
						<span class="bi bi-shop text-info lh-sm"></span><div class="col-5 text-center">Profilo venditore</div>
					</div>
				</a>
			</div>
			<div class="col-12 col-lg-4 mb-3">
				<a href="/api/auth/logout.php" class="card text-decoration-none text-reset">
					<div class="card-body d-flex justify-content-center fw-bold">
						<span class="bi bi-box-arrow-left text-danger lh-sm"></span><div class="col-5 text-center">Disconnettiti</div>
					</div>
				</a>
			</div>
		</section>
	</main>
<?php
page_end();
?>

