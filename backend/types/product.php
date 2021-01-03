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

	public $database;

	function __construct($dataArray, $database = NULL) {
		$this->database = $database;
		if (array_key_exists('id', $dataArray)) {
			$this->id = $dataArray['id'];
		}
		$this->name = $dataArray['name'];
		$this->description = $dataArray['description'];
		$this->priceInCents = $dataArray['priceInCents'];
		$this->imagePath = $dataArray['imagePath'];
		$this->insertDateTime = $dataArray['insertDateTime'];
		$this->quantity = $dataArray['quantity'];
		if (array_key_exists('soldCount', $dataArray)) {
			$this->soldCount = $dataArray['soldCount'];
		}
		$this->sellerId = $dataArray['sellerId'];
		$this->category = $dataArray['category'];
	}

	function formatPrice() {
		return number_format($this->priceInCents / 100, 2, '.', '');
	}

	function createImageBaseName() {
		return 'product-' . $this->id;
	}

	function getSeller() {
		return $this->database->sellers->byUserId($this->sellerId);
	}

	function isFavourite($user) {
		return $this->database->favourites->exists($this->id, $user->id);
	}
}

?>
