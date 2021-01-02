<?php

class ProductsController {
	function validateData($name, $description, $price, $quantity) {
		if (empty($name)) {
			throw new Exception("Il prodotto deve avere un nome");
		}

		if (empty($description)) {
			throw new Exception("Il prodotto deve avere una descrizione");
		}

		if ($price <= 0) {
			throw new Exception("Il prezzo deve essere maggiore di zero");
		}

		if ($quantity < 0) {
			throw new Exception("La quantità non può essere negativa");
		}
	}
}
