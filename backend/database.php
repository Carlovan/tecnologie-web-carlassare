<?php
require_once(BACKEND_D . 'types/product.php');
require_once(BACKEND_D . 'types/seller.php');

require_once(BACKEND_D . 'database/products.php');
require_once(BACKEND_D . 'database/users.php');
require_once(BACKEND_D . 'database/sellers.php');

class Database {
	private $seller;

	public $users;
	public $sellers;
	public $products;

	function __construct() {
		$this->users = new UsersDatabase();
		$this->sellers = new SellersDatabase();
		$this->products = new ProductsDatabase();
	}
}

?>
