<?php

require_once('seller.php');

class Product {
	public $id;
	public $name; // string
	public $description; // string
	public $priceInCents; // int
	public $imagePath; // string
	public $insertDate; // Date
	public $quantity; // int
	public $soldCount; // int
	public $seller; // Seller
	public $category; // array[string]

	function formatPrice() {
		return number_format($this->priceInCents / 100, 2, '.', '');
	}
}

?>
