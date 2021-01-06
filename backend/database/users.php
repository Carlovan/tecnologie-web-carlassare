<?php

class UsersDatabase {
	private $database;
	public $tableName = "users";

	function __construct($database) {
		$this->database = $database;
	}

	function initTable() {
		$this->database->conn()->query(
<<<QUERY
	CREATE TABLE IF NOT EXISTS {$this->tableName} (
		id VARCHAR(50) NOT NULL PRIMARY KEY,
		email VARCHAR(255) NOT NULL UNIQUE,
		name VARCHAR(255) NOT NULL,
		passwordHash VARCHAR(255) NOT NULL,
		streetAndNumber VARCHAR(255) NOT NULL,
		city VARCHAR(255) NOT NULL,
		zipCode VARCHAR(5) NOT NULL
	);
QUERY
		);
		if (!$this->database->conn()->query($query)) {
			echo "Errore creando users: ", $this->database->conn()->error;
		}
	}

	function get($id) {
		$result = $this->database->query("SELECT * FROM {$this->tableName} WHERE id = ?;", 's', [$id]);
		if (empty($result)) {
			return NULL;
		}
		return new User($result[0]);
	}

	function byEmail($email) {
		$result = $this->database->query("SELECT * FROM {$this->tableName} WHERE LOWER(email) = LOWER(?);", 's', [$email]);
		if (empty($result)) {
			return NULL;
		}
		return new User($result[0]);
	}

	function add($user) {
		if (is_null($user->id)) {
			$user->id = uniqid('u');
		}
		$this->database->statement("INSERT INTO {$this->tableName} (id, email, name, passwordHash, streetAndNumber, city, zipCode) VALUES (?, ?, ?, ?, ?, ?, ?);",
			'sssssss',
			[$user->id, $user->email, $user->name, $user->passwordHash, $user->shippingAddress->streetAndNumber, $user->shippingAddress->city, $user->shippingAddress->zipCode]);
		return $id;
	}

	function update($user) {
		$this->database->statement("UPDATE {$this->tableName} SET email = ?, name = ?, passwordHash = ?, streetAndNumber = ?, city = ?, zipCode = ? WHERE id = ?;",
			'sssssss',
			[$user->email, $user->name, $user->passwordHash, $user->shippingAddress->streetAndNumber, $user->shippingAddress->city, $user->shippingAddress->zipCode, $user->id]);
	}
}

?>
