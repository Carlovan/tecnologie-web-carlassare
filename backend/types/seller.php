<?php
require_once(BACKEND_D . 'types/user.php');

class Seller {
	public $name; // string
	public $description; // string
	public $imagePath; // string
	public $website; // string?
	public $userId; // string

	function __construct($dataArray) {
		$this->name = $dataArray['name'];
		$this->description = $dataArray['description'];
		$this->imagePath = $dataArray['imagePath'];
		$this->website = $dataArray['website'];
		$this->userId = $dataArray['userId'];
	}

	// Generates the name of the profile picture,
	// without path and extension
	function createImageBaseName() {
		return 'seller-' . $this->userId;
	}
}

?>
