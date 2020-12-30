<?php
require_once('../../config.php');
require_once(MAIN_DIR . 'utils.php');
require_once(BACKEND_D . 'database.php');
require_once(BACKEND_D . 'controllers/users.php');

session_start();

$database = new Database();
$usersController = new UsersController();
$user = loggedUserOrRedirect($database);

$streetAndNumber = trim($_POST['address']);
$city = trim($_POST['city']);
$zipCode = trim($_POST['zipCode']);

try {
	$usersController->validateAddress($streetAndNumber, $city, $zipCode);

	$user->shippingAddress->streetAndNumber = $streetAndNumber;
	$user->shippingAddress->city = $city;
	$user->shippingAddress->zipCode = $zipCode;

	$database->users->update($user);
	$_SESSION['info'] = 'Modifiche salvate correttamente';
} catch (Exception $e) {
	$_SESSION['err'] = $e->getMessage();
}

redirect('/profile/address.php');
?>

