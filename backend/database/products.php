<?php

class ProductsDatabase {
	private $database;
	public $tableName = "products";

	function __construct($database) {
		$this->database = $database;
	}

	function initTable() {
		$this->database->sellers->initTable();
		$this->database->conn()->query(
<<<QUERY
	CREATE TABLE IF NOT EXISTS {$this->tableName} (
		id VARCHAR(255) NOT NULL PRIMARY KEY,
		name VARCHAR(255) NOT NULL,
		description TEXT NOT NULL,
		priceInCents INT NOT NULL,
		imagePath VARCHAR(255) NOT NULL,
		insertDateTime INT NOT NULL,
		quantity INT NOT NULL,
		soldCount INT NOT NULL,
		sellerId VARCHAR(255) NOT NULL,
		category VARCHAR(255) NOT NULL,
		CONSTRAINT fk_seller
		FOREIGN KEY (sellerId) REFERENCES {$this->database->sellers->tableName}(userId)
	);
QUERY
		);
	}

	function assignId($product) {
		$product->id = uniqid("prod-");
	}

	function all() {
		$result = $this->database->query("SELECT * FROM {$this->tableName};");
		return array_map(function($row) { return new Product($row, $this->database); }, $result);
	}

	function lastAdded() {
		$result = $this->database->query("SELECT * FROM {$this->tableName} ORDER BY insertDateTime DESC LIMIT 10;");
		return array_map(function($row) { return new Product($row, $this->database); }, $result);
	}

	function mostSold() {
		$result = $this->database->query("SELECT * FROM {$this->tableName} ORDER BY soldCount DESC LIMIT 10;");
		return array_map(function($row) { return new Product($row, $this->database); }, $result);
	}

	function get($id) {
		$result = $this->database->query("SELECT * FROM {$this->tableName} WHERE id = ?;", 's', [$id]);
		if (empty($result)) {
			return NULL;
		}
		return new Product($result[0], $this->database);
	}

	function bySellerId($sellerId) {
		$result = $this->database->query("SELECT * FROM {$this->tableName} WHERE sellerId = ?;", 's', [$sellerId]);
		return array_map(function($row) { return new Product($row, $this->database); }, $result);
	}

	function add($product) {
		if (is_null($product->id)) {
			$this->assignId($product);
		}
		$this->database->statement("INSERT INTO {$this->tableName}(id, name, description, priceInCents, imagePath, insertDateTime, quantity, soldCount, sellerId, category)" .
			"VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);",
			'sssisiiiss',
			[$product->id, $product->name, $product->description, $product->priceInCents, $product->imagePath, $product->insertDateTime, $product->quantity, $product->soldCount, $product->sellerId, $product->category]);
	}
	
	function update($product) {
		$this->database->statement("UPDATE {$this->tableName} SET name = ?, description = ?, priceInCents = ?, imagePath = ?, quantity = ?, soldCount = ?, sellerId = ?, category = ? WHERE id = ?;",
			'ssisiisss',
			[$product->name, $product->description, $product->priceInCents, $product->imagePath, $product->quantity, $product->soldCount, $product->sellerId, $product->category, $product->id]);
	}

	function remove($id) {
		$this->database->statement("DELETE FROM {$this->tableName} WHERE id = ?;", 's', [$id]);
	}
}

?>
