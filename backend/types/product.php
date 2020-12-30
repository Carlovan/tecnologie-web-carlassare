<?php

require_once(BACKEND_D . 'types/seller.php');

class Product {
	public $id; // string
	public $name; // string
	public $description; // string
	public $priceInCents; // int
	public $imagePath; // string
	public $insertDateTime; // int (Unix)
	public $quantity; // int
	public $soldCount = 0; // int
	public $sellerId; // Seller
	public $category; // array[string]

	function formatPrice() {
		return number_format($this->priceInCents / 100, 2, '.', '');
	}

	function createImageBaseName() {
		return 'product-' . $this->id;
	}
}

?>
