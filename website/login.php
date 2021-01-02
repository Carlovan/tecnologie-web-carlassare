<?php
require_once('../config.php');
require_once(FRAGS_D . 'page_delimiters.php');

page_start('Login');
require(FRAGS_D . 'nav.php');
?>

<div class="mt-nav"></div> <!-- Utile per aggiungere il margine iniziale -->

<?php
require(FRAGS_D . 'messages.php');
?>
	<main class="container">
		<header>
			<h1>Effettua l'accesso</h1>
		</header>
		<section class="mt-2">
			<a href="/register.php">Non hai ancora un account? Registrati!</a>
		</section>
		<section class="mt-4">
			<form action="/api/auth/login.php" method="POST" class="w-75 m-auto">
				<label for="email" class="form-label">Email:</label>
				<input id="email" name="email" type="email" required class="form-control" />
				<label for="password" class="form-label mt-4">Password:</label>
				<div class="input-group mb-4">
					<input id="password" name="password" type="password" required class="form-control" />
					<input type="checkbox" class="btn-check" id="show_pass" autocomplete="off" onchange="showPassword(this.checked);" />
					<label id="show_pass_label" class="btn btn-outline-primary" for="show_pass" aria-label="Mostra password"><i class="bi bi-eye-fill"></i></label>
				</div>
				<div class="text-center">
					<input type="submit" class="btn btn-success w-50 m-auto" value="Accedi" />
				</div>
			</form>
		</section>
	</main>
	<script>
		function showPassword(isVisible) {
			const passInput = document.getElementById("password");
			const showBtnIcon = document.querySelector("#show_pass_label > i");
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
