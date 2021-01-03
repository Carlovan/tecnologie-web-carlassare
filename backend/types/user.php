<?php

class Address {
	public $streetAndNumber; // string
	public $city; // string
	public $zipCode; // string
}

class User {
	public $id; // string
	public $email; // string
	public $passwordHash; // string
	public $name; // string
	public $shippingAddress; // Address

	function __construct($dataArray) {
		if (array_key_exists('id', $dataArray)) {
			$this->id = $dataArray['id'];
		}
		$this->email = $dataArray['email'];
		$this->name = $dataArray['name'];
		$this->passwordHash = $dataArray['passwordHash'];
		$this->shippingAddress = new Address();
		$this->shippingAddress->streetAndNumber = $dataArray['streetAndNumber'];
		$this->shippingAddress->city = $dataArray['city'];
		$this->shippingAddress->zipCode = $dataArray['zipCode'];
	}
}
?>
