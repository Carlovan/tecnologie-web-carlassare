<?php

class CategoriesDatabase {
	private $database;
	public $tableName = 'categories';

	// Will be an associative rray containing the full path for each category; eg if the hierarchy is 
	//        .----CAT0---.
	//   .-CAT1-.        CAT2
	// CAT3    CAT4
	// this will be
	//   CAT0 => CAT0
	//   CAT1 => CAT0 CAT1
	//   CAT2 => CAT0 CAT2
	//   CAT3 => CAT0 CAT1 CAT3
	//   CAT4 => CAT0 CAT1 CAT4
	private $cache = NULL;

	function __construct($database) {
		$this->database = $database;
	}

	function initTable() {
		$query = 
<<<QUERY
	CREATE TABLE IF NOT EXISTS {$this->tableName} (
		name VARCHAR(255) NOT NULL PRIMARY KEY,
		parent VARCHAR(255) NULL,
		CONSTRAINT fk_cat_parent FOREIGN KEY (parent) REFERENCES {$this->tableName}(name)
	);
QUERY;

		if (!$this->database->conn()->query($query)) {
			echo "Errore creando categories: ", $this->database->conn()->error;
		}
	}

	private function getData() {
		if (is_null($this->cache)) {
			$result = $this->database->query("SELECT * FROM {$this->tableName};");
			$this->cache = array();
			while (!empty($result)) {
				foreach ($result as $k => $row) {
					if (is_null($row['parent'])) {
						$this->cache[$row['name']] = array($row['name']);
						unset($result[$k]);
					} else if (array_key_exists($row['parent'], $this->cache)) {
						$this->cache[$row['name']] = array_values($this->cache[$row['parent']]);
						$this->cache[$row['name']][] = $row['name'];
						unset($result[$k]);
					}
				}
			}
		}
	}

	function all() {
		$this->getData();
		return $this->cache;
	}

	function getPath($name) {
		$this->getData();
		return $this->cache[$name];
	}

	function exists($name) {
		$this->getData();
		return array_key_exists($name, $this->cache);
	}

}
