<?php
require_once(BACKEND_D . 'types/order.php');

class OrdersDatabase {
	private $database;
	public $tableName = 'orders';

	function __construct($database) {
		$this->database = $database;
	}

	function initTable() {
		$this->database->users->initTable();

		$query = 
<<<QUERY
	CREATE TABLE IF NOT EXISTS {$this->tableName} (
		id VARCHAR(50) NOT NULL PRIMARY KEY,
		dateTime INT NOT NULL,
		userId VARCHAR(50) NOT NULL,
		shippingAddress VARCHAR(255) NOT NULL,
		CONSTRAINT fk_ord_user FOREIGN KEY (userId) REFERENCES {$this->database->users->tableName}(id)
	);
QUERY;

		if (!$this->database->conn()->query($query)) {
			echo "Errore creando orders: ", $this->database->conn()->error;
		}
	}

	function assignId($order) {
		$order->id = uniqid('o');
	}

	function get($id) {
		$result = $this->database->query("SELECT * FROM {$this->tableName} WHERE id = ?;", 's', [$id]);
		if (empty($result)) {
			return NULL;
		}
		return new Order($result[0], $this->database);
	}

	function byUserId($userId) {
		$result = $this->database->query("SELECT * FROM {$this->tableName} WHERE userId = ? ORDER BY dateTime DESC;", 's', [$userId]);
		return array_map(function($row) { return new Order($row, $this->database); }, $result);
	}

	function bySellerId($sellerId) {
		$ot = $this->tableName;
		$ppt = $this->database->purchasedProducts->tableName;
		$pt = $this->database->products->tableName;
		$result = $this->database->query("SELECT DISTINCT $ot.* FROM $ot JOIN $ppt ON $ot.id = $ppt.orderId JOIN $pt ON $pt.id = $ppt.productId WHERE $ppt.shipped = FALSE AND $pt.sellerId = ?;",
			's', [$sellerId]);
		return array_map(function($row) { return new Order($row, $this->database); }, $result);
	}

	function add($order) {
		$this->database->statement("INSERT INTO {$this->tableName}(id, dateTime, userId, shippingAddress) VALUES (?, ?, ?, ?);",
			'siss', [$order->id, $order->dateTime, $order->userId, $order->shippingAddress]);
	}

}

?>
