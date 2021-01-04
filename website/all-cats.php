<?php
require_once('../config.php');
require_once(BACKEND_D . 'database.php');

$database = new Database();
foreach ($database->categories->all() as $cat => $path) {
	echo $cat, ' => ', implode(' - ', $path), '<br>';
}
?>
