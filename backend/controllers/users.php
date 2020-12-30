<?php

class UsersController {
	function validateData($name, $email) {
		// Check if email is well-formed
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			throw new InvalidArgumentException("L'indirizzo email specificato non è valido");
		}
		
		// Check if name is not empty
		if (empty($name)) {
			throw new InvalidArgumentException("È necessario specificare il nome");
		}
	}

	function validatePassword($password) {
		// Check if password is compliant
		$passwordRegExps = array("/[a-z]/u", "/[A-Z]/u", "/[0-9]/u", "/[a-zA-Z0-9]{8,}/u");
		if (!array_reduce($passwordRegExps, function($carry, $x) use ($password) { return $carry && preg_match($x, $password); }, true)) {
			throw new InvalidArgumentException("La password deve essere lunga almeno 8 caratteri, contenere almeno un numero, una minuscola e una maiuscola, e nessun altro carattere");
		}
	}

	function validateAddress($streetAndNumber, $city, $zipCode) {
		// Check if zip code is well formed
		if (!preg_match("/[0-9]{5}/u", $zipCode)) {
			throw new InvalidArgumentException("Il CAP inserito non è valido ($zipCode)");
		}

		// Check other variables are not empty
		if (empty($streetAndNumber)) {
			throw new InvalidArgumentException("È necessario specificare l'indirizzo");
		}
		if (empty($city)) {
			throw new InvalidArgumentException("È necessario specificare la città");
		}
	}

	function passwordHash($password) {
		$hash = password_hash($password, PASSWORD_BCRYPT);
		if ($hash === false) {
			throw RuntimeException("Something went wrong when saving the password");
		}
		return $hash;
	}
}

?>
