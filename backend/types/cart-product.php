<?php

class CartProduct {
	public $userId; // string
	public $productId; // string
	public $quantity; // int

	private $product = NULL;

	private $database;

	function __construct($dataArray, $database = NULL) {
		$this->database = $database;

		$this->userId = $dataArray['userId'];
		$this->productId = $dataArray['productId'];
		$this->quantity = $dataArray['quantity'];
	}

	function getProduct() {
		if (is_null($this->product)) {
			$this->product = $this->database->products->get($this->productId);
		}
		return $this->product;
	}

	function totalPrice() {
		return $this->getProduct()->priceInCents * $this->quantity;
	}

	function checkNewQuantity($quantity) {
		$offset = $quantity - $this->quantity;
		return $offset <= 0 || $this->getProduct()->checkFreeQuantity() >= $offset;
	}
}

?>
