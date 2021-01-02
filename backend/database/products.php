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
		$product->id = strval(count($this->products));
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
