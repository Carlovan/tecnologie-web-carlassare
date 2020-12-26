<?php

require_once('types/product.php');

class Database {
	private $products;

	function __construct() {
		$this->products = [];
		$seller = new Seller();
		$seller->name = "Giorgetti SRL";
		$seller->description = "dal 1234";
		$category = array("Cose", "Cose belle", "Rarità");
		for ($i = 0; $i < 10; $i++) {
			$newProd = new Product();
			$newProd->id = $i;
			$newProd->name = "Prodotto " . $i;
			$newProd->priceInCents = $i * 30;
			$newProd->description = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent vitae tortor aliquam, dapibus lacus ut, convallis erat. Pellentesque interdum dignissim odio, et vehicula eros sagittis eget. Duis vel auctor ex. Quisque non rhoncus justo, non rhoncus quam. Nulla et urna eu diam molestie auctor nec nec neque. Morbi vel ultrices lacus. Proin id rhoncus turpis. Morbi gravida mi non pharetra lacinia. Duis iaculis pellentesque nunc a semper. Cras lectus elit, eleifend non arcu nec, iaculis maximus libero. Proin eget urna sed augue pulvinar sodales. Suspendisse id nisl faucibus, elementum augue aliquet, rhoncus nisl. Sed vel leo id enim vestibulum ultricies sit amet quis metus. Nullam ex arcu, dictum id vestibulum quis, interdum et massa. Suspendisse at mollis risus.

Fusce id arcu justo. Aliquam lacinia imperdiet orci, ut bibendum lectus imperdiet ac. Quisque eros enim, sagittis nec ullamcorper nec, pharetra non nulla. Vivamus gravida tempus consequat. Vestibulum mattis scelerisque elit, ut aliquet est malesuada nec. Curabitur molestie metus at tellus blandit, dictum luctus quam ultrices. Maecenas vitae dui ac neque tincidunt cursus non a felis. Curabitur in facilisis nisi, id ullamcorper orci. Proin in est a lectus maximus pretium. Cras malesuada nisl id dolor suscipit, vitae suscipit ipsum faucibus. ";
			$newProd->seller = $seller;
			$newProd->imagePath = "http://liquoricemage.it/bobby.jpg";
			$newProd->category = $category;

			$this->products[] = $newProd;
		}
	}

	function allProducts() {
		return $this->products;
	}

	function getProduct($id) {
		return $this->products[$id];
	}

	function getCartProducts() {
		return $this->products;
	}
}

?>
