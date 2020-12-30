<?php
require_once(BACKEND_D . 'types/user.php');

class Seller {
	public $name; // string
	public $description; // string
	public $imagePath; // string
	public $website; // string?
	public $userId; // string

	// Generates the name of the profile picture,
	// without path and extension
	function createImageBaseName() {
		return 'seller-' . $this->userId;
	}
}

?>
