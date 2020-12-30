<?php
require_once('../../../config.php');
require_once(MAIN_DIR . 'utils.php');
require_once(BACKEND_D . 'database.php');
require_once(BACKEND_D . 'controllers/auth.php');

$database = new Database();
$authController = new AuthController($database);

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$password = trim($_POST['password']);
$address = trim($_POST['address']);
$city = trim($_POST['city']);
$zipCode = trim($_POST['zipCode']);

try {
	$authController->register($name, $email, $password, $address, $city, $zipCode); 
	redirect('/login.php');
} catch (Exception $e) {
	redirect('/register.php?err=' . urlencode($e->getMessage()));
}
?>
