<?php
require_once(MAIN_DIR . 'utils.php');
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
	public $sellerId; // string
	public $category; // string

	public $database;

	private $seller;

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
		return formatPrice($this->priceInCents);
	}

	function createImageBaseName() {
		return 'product-' . $this->id;
	}

	function getSeller() {
		if (is_null($this->seller)) {
			$this->seller = $this->database->sellers->byUserId($this->sellerId);
		}
		return $this->seller;
	}

	function isFavourite($user) {
		return $this->database->favourites->exists($this->id, $user->id);
	}

	function getCategory() {
		return $this->database->categories->getPath($this->category);
	}

	// Calculates the quantity of this product, accounting also for the ones in the cart but not purchased yet
	function checkFreeQuantity() {
		$busy = $this->database->cart->getTotalProductQuantity($this->id);
		return $this->quantity - $busy;
	}
}

?>
