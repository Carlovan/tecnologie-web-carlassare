<?php
require_once(BACKEND_D . "types/user.php");
require_once(BACKEND_D . "controllers/users.php");

class AuthController {
	private $database;
	private $usersController;

	function __construct($database) {
		$this->database = $database;
		$this->usersController = new UsersController();
	}

	function register($name, $email, $password, $streetAndNumber, $city, $zipCode) {
		$this->usersController->validateData($name, $email);
		$this->usersController->validatePassword($password);
		$this->usersController->validateAddress($streetAndNumber, $city, $zipCode);

		// Check if email already registered
		if ($this->database->users->byEmail($email) !== NULL) {
			throw new InvalidArgumentException("L'indirizzo email specificato è già in uso");
		}

		$user = new User(array(
			'name' => $name,
			'email' => $email,
			'passwordHash' => $this->usersController->passwordHash($password),
			'shippingAddress' => new Address(),
			'streetAndNumber' => $streetAndNumber,
			'city' => $city,
			'zipCode' => $zipCode
		));

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
