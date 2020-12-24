<?php

require_once('seller.php');

class Product {
	public $id;
	public $name;
	public $description;
	public $priceInCents;
	public $imagePath;
	public $insertDate;
	public $quantity;
	public $soldCount;
	public $seller;

	function formatPrice() {
		return number_format($this->priceInCents / 100, 2, '.', '');
	}
}

?>
