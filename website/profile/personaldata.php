<?php
require_once('../../config.php');
require_once(MAIN_DIR . 'utils.php');
require_once(FRAGS_D . 'page_delimiters.php');
require_once(BACKEND_D . 'database.php');

session_start();

$database = new Database();
$user = loggedUserOrRedirect($database);

page_start('Dati personali');
require(FRAGS_D . 'nav.php');
?>
	<main class="container mt-nav">
		<div class="col-lg-5 mx-lg-auto">
			<header>
				<h1 class="text-lg-center">Dati personali di <?= $user->name ?></h1>
			</header>
			<section class="mt-4 row g-0">
				<form action="/api/save-personal-data.php" method="POST" class="col-10 m-auto">
					<label for="name" class="form-label">Nome e cognome:</label>
					<input id="name" name="name" type="text" required class="form-control" value="<?= $user->name ?>"/>
					<label for="email" class="form-label mt-2">Email:</label>
					<input id="email" name="email" type="email" required class="form-control" value="<?= $user->email ?>"/>
					<label for="old-password" class="form-label mt-2">Password attuale:</label>
					<div class="input-group">
						<input id="old-password" name="old-password" type="password" minlength="8" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}" class="form-control" />
						<input type="checkbox" class="btn-check" id="show-old-password" autocomplete="off" onchange="showPassword('old-password', this.checked);" />
						<label id="show-old-password-label" class="btn btn-outline-primary" for="show-old-password" aria-label="Mostra password"><i class="bi bi-eye-fill"></i></label>
					</div>
					<label for="new-password" class="form-label mt-2">Nuova password:</label>
					<div class="input-group">
						<input id="new-password" name="new-password" type="password" minlength="8" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}" aria-describedby="passwordHelpBlock" class="form-control" />
						<input type="checkbox" class="btn-check" id="show-new-password" autocomplete="off" onchange="showPassword('new-password', this.checked);" />
						<label id="show-new-password-label" class="btn btn-outline-primary" for="show-new-password" aria-label="Mostra password"><i class="bi bi-eye-fill"></i></label>
					</div>
					<div id="passwordHelpBlock" class="form-text">
						La password deve essere lunga almeno 8 caratteri e contenere almeno un numero, una minuscola e una maiuscola, e nessun altro carattere.
					</div>
					<div class="text-center my-4">
						<input type="submit" class="btn btn-success w-50 m-auto" value="Salva modifiche" />
					</div>
				</form>
			</section>
		</div>
	</main>
	<script>
		function showPassword(id, isVisible) {
			const passInput = document.getElementById(id);
			const showBtnIcon = document.querySelector("#show-" + id + "-label > i");
			if (isVisible === true) {
				passInput.type = "text";
				showBtnIcon.className = "bi bi-eye-slash-fill";
			} else if (isVisible === false) {
				passInput.type = "password";
				showBtnIcon.className = "bi bi-eye-fill";
			}
		}
	</script>
<?php
page_end();
?>
