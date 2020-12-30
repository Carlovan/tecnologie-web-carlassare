<?php
require_once('../../config.php');
require_once(MAIN_DIR . 'utils.php');
require_once(FRAGS_D . 'page_delimiters.php');
require_once(BACKEND_D . 'database.php');

session_start();

$database = new Database();
$user = loggedUserOrRedirect($database);

page_start('Indirizzo');
require(FRAGS_D . 'nav.php');
?>

<div class="mt-nav"></div> <!-- Utile per aggiungere il margine iniziale -->

<?php
if (isset($_SESSION['err'])) { ?>
	<div class="alert alert-danger mx-3" role="alert">
		<b>Si è verificato un errore: </b><?= $_SESSION['err'] ?>
	</div>
<?php
	unset($_SESSION['err']);
}

if (isset($_SESSION['info'])) { ?>
	<div class="alert alert-success mx-3" role="alert">
		<?= $_SESSION['info'] ?>
	</div>
<?php
	unset($_SESSION['info']);
}
?>
	<main class="container">
		<header>
			<h1>Indirizzo di <?= $user->name ?></h1>
		</header>
		<section class="mt-4 row g-0">
			<form action="/api/save-address.php" method="POST" class="col-10 m-auto">
				<label for="address" class="form-label mt-2">Indirizzo:</label>
				<input id="address" name="address" type="text" required class="form-control" value="<?= $user->shippingAddress->streetAndNumber ?>" />
				<div class="row g-3">
					<div class="col-8">
						<label for="city" class="form-label mt-2">Città:</label>
						<input id="city" name="city" type="text" required class="form-control" value="<?= $user->shippingAddress->city ?>" />
					</div>
					<div class="col">
						<label for="zipCode" class="form-label mt-2">CAP:</label>
						<input id="zipCode" name="zipCode" type="text" required inputmode="decimal" minlength="5" maxlength="5" class="form-control" value="<?= $user->shippingAddress->zipCode ?>" />
					</div>
				</div>
				<div class="text-center my-4">
					<input type="submit" class="btn btn-success w-50 m-auto" value="Salva modifiche" />
				</div>
			</form>
		</section>
	</main>
<?php
page_end();
?>
