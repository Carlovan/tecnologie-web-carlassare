<?php

class SellersDatabase {
	private $sellers = NULL;
	private $filename = DB_D . 'sellers.db';

	private function loadData() {
		if (is_null($this->sellers)) {
			$this->sellers = unserialize(file_get_contents($this->filename));
			if ($this->sellers === false) {
				$this->sellers = array();
				$this->saveData();
			}
		}
	}
	private function saveData() {
		file_put_contents($this->filename, serialize($this->sellers));
	}

	function byUserId($userId) {
		$this->loadData();

		foreach ($this->sellers as $seller) {
			if ($seller->userId === $userId) {
				return $seller;
			}
		}
		return NULL;
	}

	function byName($name) {
		$this->loadData();

		foreach ($this->sellers as $seller) {
			if (strtolower($seller->name) === strtolower($name)) {
				return $seller;
			}
		}
		return NULL;
	}

	function add($seller) {
		$this->loadData();
		$this->sellers[] = $seller;
		$this->saveData();
	}

	function update($seller) {
		$this->loadData();

		foreach ($this->sellers as $k => $s) {
			if ($s->userId === $seller->userId) {
				$this->sellers[$k] = $seller;
				break;
			}
		}

		$this->saveData();
	}

	function remove($seller) {
		$this->loadData();

		foreach ($this->sellers as $k => $s) {
			if ($s->userId === $seller->userId) {
				unset($this->sellers[$k]);
				break;
			}
		}

		$this->saveData();
	}
}

?>
