<?php

class FavouritesDatabase {
	private $database;
	public $tableName = 'favourites';


	function __construct($database) {
		$this->database = $database;
	}

	function initTable() {
		$this->database->users->initTable();
		$this->database->products->initTable();

		$query = 
<<<QUERY
	CREATE TABLE IF NOT EXISTS {$this->tableName} (
		userId VARCHAR(255) NOT NULL,
		productId VARCHAR(255) NOT NULL,
		CONSTRAINT fk_fav_user FOREIGN KEY (userId) REFERENCES {$this->database->users->tableName}(id),
		CONSTRAINT fk_fav_prod FOREIGN KEY (productId) REFERENCES {$this->database->products->tableName}(id),
		PRIMARY KEY uniq_pair (userId, productId)
	);
QUERY;

		if (!$this->database->conn()->query($query)) {
			echo "Errore creando favourites: ", $this->database->conn()->error;
		}
	}

	function byUserId($id) {
		$favourites = $this->database->query("SELECT * FROM {$this->tableName} WHERE userId = ?;", 's', [$id]);
		if (empty($favourites)) {
			return array();
		}
		$placeholders = implode(', ', array_fill(0, count($favourites), '?'));
		$products = $this->database->query("SELECT * FROM {$this->database->products->tableName} WHERE id IN (" . $placeholders . ");",
			str_repeat('s', count($favourites)),
			array_map(function($f) { return $f['productId']; }, $favourites));
		return array_map(function($row) { return new Product($row, $this->database); }, $products);
	}

	function exists($productId, $userId) {
		$result = $this->database->query("SELECT 1 FROM {$this->tableName} WHERE productId = ? AND userId = ?;", 'ss', [$productId, $userId]);
		return !empty($result);
	}

	function add($productId, $userId) {
		$this->database->statement("INSERT INTO {$this->tableName} (productId, userId) VALUES (?, ?);", 'ss', [$productId, $userId]);
	}

	function remove($productId, $userId) {
		$this->database->statement("DELETE FROM {$this->tableName} WHERE productId = ? AND userId = ?;", 'ss', [$productId, $userId]);
	}
}

?>
