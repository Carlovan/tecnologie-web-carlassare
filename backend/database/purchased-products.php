<?php
require_once(BACKEND_D . 'types/purchased-product.php');

class PurchasedProductsDatabase {
	private $database;
	public $tableName = 'purchasedProducts';

	function __construct($database) {
		$this->database = $database;
	}

	function initTable() {
		$this->database->orders->initTable();

		// Here some info about the products are saved so that is possible
		// to handle the case where they will be deleted in the future
		$query = 
<<<QUERY
	CREATE TABLE IF NOT EXISTS {$this->tableName} (
		orderId VARCHAR(255) NOT NULL,
		originalProductId VARCHAR(255) NOT NULL,
		productId VARCHAR(255) NULL,
		quantity INT NOT NULL,
		productName VARCHAR(255) NOT NULL,
		priceInCents INT NOT NULL,
		sellerName VARCHAR(255) NOT NULL,
		CONSTRAINT fk_purch_order FOREIGN KEY (orderId) REFERENCES {$this->database->orders->tableName}(id),
		CONSTRAINT fk_purch_product FOREIGN KEY (productId) REFERENCES {$this->database->products->tableName}(id)
			ON DELETE SET NULL,
		PRIMARY KEY uniq_pair_purch (orderId, originalProductId)
	);
QUERY;

		if (!$this->database->conn()->query($query)) {
			echo "Errore creando purchasedProducts: ", $this->database->conn()->error;
		}
	}

	function byOrderId($orderId) {
		$result = $this->database->query("SELECT * FROM {$this->tableName} WHERE orderId = ?;", 's', [$orderId]);
		return array_map(function($row) { return new PurchasedProduct($row, $this->database); }, $result);
	}

	function addAll($purchasedProducts) {
		$placeholders = implode(', ', array_fill(0, count($purchasedProducts), '(?, ?, ?, ?, ?, ?, ?)'));
		$placeholdersTypes = str_repeat('sssisis', count($purchasedProducts));
		$placeholdersValues = array_merge(...array_map(
			function($p) { return [$p->orderId, $p->originalProductId, $p->productId, $p->quantity, $p->productName, $p->priceInCents, $p->sellerName]; },
			$purchasedProducts
		));
		$this->database->statement("INSERT INTO {$this->tableName}(orderId, originalProductId, productId, quantity, productName, priceInCents, sellerName) VALUES $placeholders;",
			$placeholdersTypes, $placeholdersValues);
	}

}

?>
