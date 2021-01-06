<?php
require_once(BACKEND_D . 'types/cart-product.php');

class CartDatabase {
	private $database;
	public $tableName = "cart";

	function __construct($database) {
		$this->database = $database;
	}

	function initTable() {
		$this->database->users->initTable();
		$this->database->products->initTable();

		$query = 
<<<QUERY
	CREATE TABLE IF NOT EXISTS {$this->tableName} (
		userId VARCHAR(50) NOT NULL,
		productId VARCHAR(50) NOT NULL,
		quantity INT NOT NULL,
		CONSTRAINT fk_cart_user FOREIGN KEY (userId) REFERENCES {$this->database->users->tableName}(id),
		CONSTRAINT fk_cart_prod FOREIGN KEY (productId) REFERENCES {$this->database->products->tableName}(id) ON DELETE CASCADE,
		PRIMARY KEY uniq_cart_pair (userId, productId)
	);
QUERY;

		if (!$this->database->conn()->query($query)) {
			echo "Errore creando cart: ", $this->database->conn()->error;
		}
	}

	function get($productId, $userId) {
		$result = $this->database->query("SELECT * FROM {$this->tableName} WHERE userId = ? AND productId = ?;", 'ss', [$userId, $productId]);
		if (empty($result)) {
			return NULL;
		}
		return new CartProduct($result[0], $this->database);
	}

	private function add($cartProduct) {
		$this->database->statement("INSERT INTO {$this->tableName}(userId, productId, quantity) VALUES (?, ?, ?);",
			'ssi', [$cartProduct->userId, $cartProduct->productId, $cartProduct->quantity]);
	}

	function getOrAdd($productId, $userId) {
		$cartProduct = $this->get($productId, $userId);
		if (is_null($cartProduct)) {
			$cartProduct = new CartProduct(array(
				'userId' => $userId,
				'productId' => $productId,
				'quantity' => 0
			), $this->database);
			$this->add($cartProduct);
		}
		return $cartProduct;
	}

	function byUserId($userId) {
		$result = $this->database->query("SELECT * FROM {$this->tableName} WHERE userId = ?;", 's', [$userId]);
		return array_map(function($row) { return new CartProduct($row, $this->database); }, $result);
	}

	function getTotalProductQuantity($productId) {
		$result = $this->database->query("SELECT SUM(quantity) as busy FROM {$this->tableName} WHERE productId = ?;", 's', [$productId]);
		return $result[0]['busy'];
	}

	function update($cartProduct) {
		$this->database->statement("UPDATE {$this->tableName} SET quantity = ? WHERE userId = ? AND productId = ?;",
			'iss', [$cartProduct->quantity, $cartProduct->userId, $cartProduct->productId]);
	}

	function remove($productId, $userId) {
		$this->database->statement("DELETE FROM {$this->tableName} WHERE userId = ? AND productId = ?;", 'ss', [$userId, $productId]);
	}

	function removeAllByUserId($userId) {
		$this->database->statement("DELETE FROM {$this->tableName} WHERE userId = ?;", 's', [$userId]);
	}
}

?>
