<?php

require 'types/product.php';

class Database {
	function allProducts() {
		$result = [];
		$seller = new Seller();
		$seller->name = "Giorgetti SRL";
		$seller->description = "dal 1234";
		for ($i = 0; $i < 10; $i++) {
			$newProd = new Product();
			$newProd->id = $i;
			$newProd->name = "Prodotto " . $i;
			$newProd->priceInCents = $i * 30;
			$newProd->description = "Questo è un prodotto magnifico";
			$newProd->seller = $seller;
			$newProd->imagePath = "http://liquoricemage.it/bobby.jpg";

			$result[] = $newProd;
		}
		return $result;
	}
}

?>
