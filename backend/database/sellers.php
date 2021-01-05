<?php

class SellersDatabase {
	private $database;
	public $tableName = "sellers";

	function __construct($database) {
		$this->database = $database;
	}

	function initTable() {
		$this->database->users->initTable();
		$this->database->conn()->query(
<<<QUERY
	CREATE TABLE IF NOT EXISTS {$this->tableName} (
		userId VARCHAR(255) NOT NULL PRIMARY KEY,
		name VARCHAR(255) NOT NULL,
		description TEXT NOT NULL,
		imagePath VARCHAR(255) NOT NULL,
		website VARCHAR(255),
		CONSTRAINT fk_user
		FOREIGN KEY (userId) REFERENCES {$this->database->users->tableName}(id)
	);
QUERY
		);
	}

	function all() {
		$result = $this->database->query("SELECT * FROM {$this->tableName};");
		return array_map(function($row) { return new Seller($row); }, $result);
	}

	function byUserId($userId) {
		$result = $this->database->query("SELECT * FROM {$this->tableName} WHERE userId = ?;", 's', [$userId]);
		if (empty($result)) {
			return NULL;
		}
		return new Seller($result[0]);
	}

	function byName($name) {
		$result = $this->database->query("SELECT * FROM {$this->tableName} WHERE LOWER(name) = LOWER(?);", 's', [$name]);
		if (empty($result)) {
			return NULL;
		}
		return new Seller($result[0]);
	}

	function add($seller) {
		$this->database->statement("INSERT INTO {$this->tableName}(userId, name, description, imagePath, website) VALUES (?, ?, ?, ?, ?);",
			'sssss', [$seller->userId, $seller->name, $seller->description, $seller->imagePath, $seller->website]);
	}

	function update($seller) {
		$this->database->statement("UPDATE {$this->tableName} SET name = ?, description = ?, imagePath = ?, website = ? WHERE userId = ?;",
			'sssss', [$seller->name, $seller->description, $seller->imagePath, $seller->website, $seller->userId]);
	}

	function remove($id) {
		$this->database->statement("DELETE FROM {$this->tableName} WHERE userId = ?;", 's', [$seller->userId]);
	}
}

?>
