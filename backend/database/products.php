<?php

class ProductsDatabase {
	private $database;
	private $products = NULL;
	private $filename = DB_D . 'products.db';

	function __construct($database) {
		$this->database = $database;
	}

	private function loadData() {
		if (is_null($this->products)) {
			$this->products = unserialize(file_get_contents($this->filename));
			if ($this->products === false) {
				$this->products = array();
				$this->saveData();
			}
			foreach ($this->products as $product) {
				$product->database = $this->database;
			}
		}
	}
	private function saveData() {
		file_put_contents($this->filename, serialize($this->products));
	}

	function assignId($product) {
		$product->id = uniqid("prod-");
	}

	function all() {
		$this->loadData();
		return array_values($this->products);
	}

	function lastAdded() {
		$this->loadData();
		$ps = array_values($this->products);
		usort($ps, function($a, $b) {return $b->insertDateTime - $a->insertDateTime; });
		return array_slice($ps, 0, 10);
	}

	function mostSold() {
		$this->loadData();
		$ps = array_values($this->products);
		usort($ps, function($a, $b) {return $b->soldCount - $a->soldCount; });
		return array_slice($ps, 0, 10);
	}

	function get($id) {
		$this->loadData();

		foreach ($this->products as $product) {
			if ($product->id === $id) {
				return $product;
			}
		}
		return NULL;
	}

	function bySellerId($sellerId) {
		$this->loadData();
		return array_values(array_filter($this->products, function($p) use ($sellerId) { return $p->sellerId === $sellerId; }));
	}

	function add($product) {
		$this->loadData();
		if (is_null($product->id)) {
			$this->assignId($product);
		}
		$this->products[] = $product;
		$this->saveData();
		return $product->id;
	}
	
	function update($product) {
		$this->loadData();
		foreach ($this->products as $k => $p) {
			if ($p->id === $product->id) {
				$this->products[$k] = $product;
				break;
			}
		}
		$this->saveData();
	}

	function remove($id) {
		$this->loadData();
		foreach ($this->products as $k => $p) {
			if ($p->id === $id) {
				unset($this->products[$k]);
			}
		}
		$this->saveData();
	}
}

?>
