<?php

class ProductsDatabase {
	private $products = NULL;
	private $filename = DB_D . 'products.db';

	private function loadData() {
		if (is_null($this->products)) {
			$this->products = unserialize(file_get_contents($this->filename));
			if ($this->products === false) {
				$this->products = array();
				$this->saveData();
			}
		}
	}
	private function saveData() {
		file_put_contents($this->filename, serialize($this->products));
	}

	function add($product) {
		$this->loadData();
		$product->id = count($this->products);
		$this->products[] = $product;
		$this->saveData();
	}

	function bySellerId($sellerId) {
		$this->loadData();
		return array_values(array_filter($this->products, function($p) use ($sellerId) { return $p->sellerId === $sellerId; }));
	}
}

?>
