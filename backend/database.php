<?php

require_once('types/product.php');

class Database {
	private $products;

	function __construct() {
		$this->products = [];
		$seller = new Seller();
		$seller->name = "Giorgetti SRL";
		$seller->description = "dal 1234";
		$category = array("Cose", "Cose belle", "Rarità");
		for ($i = 0; $i < 10; $i++) {
			$newProd = new Product();
			$newProd->id = $i;
			$newProd->name = "Prodotto " . $i;
			$newProd->priceInCents = $i * 30;
			$newProd->description = "Questo è un prodotto magnifico";
			$newProd->seller = $seller;
			$newProd->imagePath = "http://liquoricemage.it/bobby.jpg";
			$newProd->category = $category;

			$this->products[] = $newProd;
		}
	}

	function allProducts() {
		return $this->products;
	}

	function getProduct($id) {
		return $this->products[$id];
	}
}

?>
