<?php
require_once(BACKEND_D . 'types/user.php');

class Seller {
	public $name; // string
	public $description; // string
	public $imagePath; // string
	public $website; // string?
	public $user; // User

	function __construct() {}
}

?>
