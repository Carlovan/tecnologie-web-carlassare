<?php

class Order {
	public $id; // string
	public $userId; // string
	public $shippingAddress; // string
	public $dateTime; // int

	private $cacheProds = NULL;

	function __construct($dataArray, $database = NULL) {
		$this->database = $database;

		if (array_key_exists('id', $dataArray)) {
			$this->id = $dataArray['id'];
		}
		$this->userId = $dataArray['userId'];
		$this->shippingAddress = $dataArray['shippingAddress'];
		$this->dateTime = $dataArray['dateTime'];
	}

	private function getProds() {
		if (is_null($this->cacheProds)) {
			$this->cacheProds = $this->database->purchasedProducts->byOrderId($this->id);
		}
		return $this->cacheProds;
	}

	function getProducts() {
		return $this->getProds();
	}

	function getProductsBySellerId($sellerId) {
		return $this->database->purchasedProducts->byOrderAndSellerId($this->id, $sellerId);
	}

	function getFirstProductName() {
		return $this->getProds()[0]->productName;
	}

	function totalObjects() {
		$total = 0;
		foreach ($this->getProds() as $p) {
			$total += $p->quantity;
		}
		return $total;
	}

	function totalPriceInCents() {
		$total = 0;
		foreach ($this->getProds() as $p) {
			$total += $p->totalPriceInCents();
		}
		return $total;
	}

	function formatDateTime() {
		return date('H:i d/m/Y', $this->dateTime);
	}
}

?>
