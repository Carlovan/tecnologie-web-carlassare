<?php

class Address {
	public $streetAndNumber; // string
	public $city; // string
	public $zipCode; // string
}

class User {
	public $email; // string
	public $passwordHash; // string
	public $name; // string
	public $shippingAddress; // Address

	function isSeller() {
		return false;
	}
}
?>
