<?php
require_once('../config.php');
require_once(FRAGS_D . 'page_delimiters.php');

session_start();

page_start('Login');
require(FRAGS_D . 'nav.php');
?>
	<main class="container mt-nav">
		<div class="col-lg-4 mx-lg-auto">
			<h1>Effettua l'accesso</h1>
			<a href="/register.php" class="mt-2">Non hai ancora un account? Registrati!</a>
			<form action="/api/auth/login.php" method="POST" class="w-75 mx-auto mt-4">
				<label for="email" class="form-label">Email:</label>
				<input id="email" name="email" type="email" required class="form-control" />
				<label for="password" class="form-label mt-4">Password:</label>
				<div class="input-group mb-4">
					<input id="password" name="password" type="password" required class="form-control" />
					<input type="checkbox" class="btn-check" id="show_pass" onchange="showPassword(this.checked);" />
					<label id="show_pass_label" class="btn btn-outline-primary" for="show_pass">
						<span class="bi bi-eye-fill" aria-hidden="true"></span>
						<span class="visually-hidden">Mostra o nascondi password</span>
					</label>
				</div>
				<div class="text-center">
					<input type="submit" class="btn btn-success w-50 m-auto" value="Accedi" />
				</div>
			</form>
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
