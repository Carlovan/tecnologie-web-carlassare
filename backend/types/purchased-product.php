<?php

class PurchasedProduct {
	private $database;

	public $orderId; // string 
	public $originalProductId; // string
	public $productId; // string?
	public $quantity; // int
	public $productName; // string
	public $priceInCents; // int
	public $sellerName; // string
	public $shipped = false; // bool

	function __construct($dataArray, $database = NULL) {
		$this->database = $database;

		$this->orderId = $dataArray['orderId'];
		$this->productId = $dataArray['productId'];
		if (array_key_exists('originalProductId', $dataArray)) {
			$this->originalProductId = $dataArray['originalProductId'];
		} else {
			$this->originalProductId = $this->productId;
		}
		$this->quantity = $dataArray['quantity'];
		$this->productName = $dataArray['productName'];
		$this->priceInCents = $dataArray['priceInCents'];
		$this->sellerName = $dataArray['sellerName'];
		if (array_key_exists('shipped', $dataArray)) {
			$this->shipped = boolval($dataArray['shipped']);
		}
	}

	function totalPriceInCents() {
		return $this->priceInCents * $this->quantity;
	}

	function getProduct() {
		if (is_null($this->productId)) {
			return NULL;
		}
		return $this->database->products->get($this->productId);
	}
}

?>
