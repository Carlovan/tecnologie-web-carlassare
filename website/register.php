<?php
require_once('../config.php');
require_once(FRAGS_D . 'page_delimiters.php');

session_start();

page_start('Registrazione');
require(FRAGS_D . 'nav.php');
?>
	<main class="container mt-nav">
		<div class="col-lg-4 mx-lg-auto">
			<h1>Registrati</h1>
			<div class="mt-4 row g-0">
				<form action="/api/auth/register.php" method="POST" class="col-10 m-auto">
					<label for="name" class="form-label">Nome e cognome:</label>
					<input id="name" name="name" type="text" required class="form-control" />
					<label for="email" class="form-label mt-2">Email:</label>
					<input id="email" name="email" type="email" required class="form-control" />
					<label for="password" class="form-label mt-2">Password:</label>
					<div class="input-group">
						<input id="password" name="password" type="password" required minlength="8" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]{8,}" aria-describedby="passwordHelpBlock" class="form-control" />
						<input type="checkbox" class="btn-check" id="show_pass" onchange="showPassword(this.checked);" />
						<label id="show_pass_label" class="btn btn-outline-primary" for="show_pass">
							<span class="bi bi-eye-fill" aria-hidden="true"></span>
							<span class="visually-hidden">Mostra o nascondi password</span>
						</label>
					</div>
					<div id="passwordHelpBlock" class="form-text">
						La password deve essere lunga almeno 8 caratteri e contenere almeno un numero, una minuscola e una maiuscola, e nessun altro carattere.
					</div>
					<label for="address" class="form-label mt-2">Indirizzo:</label>
					<input id="address" name="address" type="text" required class="form-control" />
					<div class="row g-3">
						<div class="col-8">
							<label for="city" class="form-label mt-2">Città:</label>
							<input id="city" name="city" type="text" required class="form-control" />
						</div>
						<div class="col">
							<label for="zipCode" class="form-label mt-2">CAP:</label>
							<input id="zipCode" name="zipCode" type="text" required inputmode="decimal" minlength="5" maxlength="5" class="form-control" />
						</div>
					</div>
					<div class="text-center my-4">
						<input type="submit" class="btn btn-success w-50 m-auto" value="Registrati" />
					</div>
				</form>
			</div>
		</div>
	</main>
	<script>
		function showPassword(isVisible) {
			const passInput = document.getElementById("password");
			const showBtnIcon = document.querySelector("#show_pass_label > .bi");
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

