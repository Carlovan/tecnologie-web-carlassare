<?php
require_once(BACKEND_D . 'types/product.php');
require_once(BACKEND_D . 'types/seller.php');

require_once(BACKEND_D . 'database/products.php');
require_once(BACKEND_D . 'database/users.php');
require_once(BACKEND_D . 'database/sellers.php');
require_once(BACKEND_D . 'database/favourites.php');
require_once(BACKEND_D . 'database/cart.php');
require_once(BACKEND_D . 'database/categories.php');

class Database {
	private $connection;

	public $users;
	public $sellers;
	public $products;
	public $favourites;
	public $cart;
	public $catagories;

	function __construct() {
		$this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

		$this->users = new UsersDatabase($this);
		$this->sellers = new SellersDatabase($this);
		$this->products = new ProductsDatabase($this);
		$this->favourites = new FavouritesDatabase($this);
		$this->cart = new CartDatabase($this);
		$this->categories = new CategoriesDatabase($this);
	}

	function conn() {
		return $this->connection;
	}

	function statement($statement, $bindTypes = '', $bindValues = array()) {
		$stmt = $this->prepareQuery($statement, $bindTypes, $bindValues);
		if (!$stmt->execute()) {
			throw new Exception("Errore nell'esecuzione della query: " . $this->connection->error);
		}
		$stmt->close();
	}

	function query($statement, $bindTypes = '', $bindValues = array()) {
		$stmt = $this->prepareQuery($statement, $bindTypes, $bindValues);
		if (!$stmt->execute()) {
			throw new Exception("Errore nell'esecuzione della query: " . $this->connection->error);
		}
		if (!($result = $stmt->get_result())) {
			throw new Exception("Errore nell'ottenimento del risultato: " . $this->connection->error);
		}
		$data = $result->fetch_all(MYSQLI_ASSOC);
		$result->free();
		$stmt->close();
		return $data;
	}

	function initDb() {
		$this->favourites->initTable();
		$this->cart->initTable();
		$this->categories->initTable();
	}

	private function prepareQuery($statement, $bindTypes, $bindValues) {
		if (!($stmt = $this->connection->prepare($statement))) {
			throw new Exception("Errore nella preparazione dello statement: " . $this->connection->error);
		}
		if (!empty($bindValues)) {
			if (count($bindValues) !== strlen($bindTypes)) {
				throw new Exception("Parametri non validi: " . $this->connection->error);
			}
			$stmt->bind_param($bindTypes, ...$bindValues);
		}

		return $stmt;
	}
}

?>
