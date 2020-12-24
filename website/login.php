<?php
require('../config.php');
?>
<!DOCTYPE html>
<html lang="it">
<head>
	<meta charset="UTF-8">
	<title><?= TITLE ?> - Login</title>
	<script>
		function togglePassword(id) {
			const elem = document.getElementById(id);
			if (elem.type === "text") {
				elem.type = "password";
			} else if (elem.type === "password") {
				elem.type = "text";
			}
		}
	</script>
</head>
<body>
	<?php require('../fragments/nav.php'); ?>
	<main>
		<form action="do_login.php">
			<label for="email">Email:</label>
			<input name="email" type="text" />
			<label for="password">Password:</label>
			<input id="password" name="password" type="password" />
			<input type="button" value="Mostra" onclick="togglePassword('password');" />
			<input type="submit" value="Accedi" />
		</form>
	</main>
</body>
</html>
