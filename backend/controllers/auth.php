<?php
require_once(BACKEND_D . "types/user.php");

class AuthController {
	private $database;

	function __construct($database) {
		$this->database = $database;
	}

	function register($name, $email, $password, $streetAndNumber, $city, $zipCode) {
		// Check if email is well-formed
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			throw new InvalidArgumentException("L'indirizzo email specificato non è valido");
		}

		// Check if zip code is well formed
		if (!preg_match("/[0-9]{5}/u", $zipCode)) {
			throw new InvalidArgumentException("Il CAP inserito non è valido ($zipCode)");
		}

		// Check other variables are not empty
		if (empty($name)) {
			throw new InvalidArgumentException("È necessario specificare il nome");
		}
		if (empty($streetAndNumber)) {
			throw new InvalidArgumentException("È necessario specificare l'indirizzo");
		}
		if (empty($city)) {
			throw new InvalidArgumentException("È necessario specificare la città");
		}

		// Check if password is compliant
		$passwordRegExps = array("/[a-z]/u", "/[A-Z]/u", "/[0-9]/u", "/[a-zA-Z0-9]{8,}/u");
		if (!array_reduce($passwordRegExps, function($carry, $x) use ($password) { return $carry && preg_match($x, $password); }, true)) {
			throw new InvalidArgumentException("La password deve essere lunga almeno 8 caratteri, contenere almeno un numero, una minuscola e una maiuscola, e nessun altro carattere");
		}

		// Check if email already registered
		if ($this->database->users->byEmail($email) !== NULL) {
			throw new InvalidArgumentException("L'indirizzo email specificato è già in uso");
		}

		$user = new User();
		$user->name = $name;
		$user->email = $email;
		$user->passwordHash = password_hash($password, PASSWORD_BCRYPT);
		if ($user->passwordHash == false) {
			throw RuntimeException("Something went wrong when saving the password");
		}
		$user->shippingAddress = new Address();
		$user->shippingAddress->streetAndNumber = $streetAndNumber;
		$user->shippingAddress->city = $city;
		$user->shippingAddress->zipCode = $zipCode;

		$this->database->users->add($user);
	}

	function login($email, $password) {
		$user = $this->database->users->byEmail($email);
		$error = new InvalidArgumentException("Email o password errati");
		if (is_null($user)) {
			throw $error;
		}

		if (!password_verify($password, $user->passwordHash)) {
			throw $error;
		}
		return $user;
	}
}

?>
