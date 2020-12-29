<?php
require_once('../../../config.php');
require_once(BACKEND_D . 'database.php');
require_once(BACKEND_D . 'controllers/auth.php');

$database = new Database();
$authController = new AuthController($database);

try {
	$authController->register($_POST['name'], $_POST['email'], $_POST['password'], $_POST['address'], $_POST['city'], $_POST['zipCode']); 
	echo "BENE";
} catch (Exception $e) {
	echo "MALE: ", $e->getMessage();
}

?>
