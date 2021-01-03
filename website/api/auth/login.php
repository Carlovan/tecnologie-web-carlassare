<?php
require_once('../../../config.php');
require_once(MAIN_DIR . 'utils.php');
require_once(BACKEND_D . 'database.php');
require_once(BACKEND_D . 'controllers/auth.php');

$database = new Database();
$authController = new AuthController($database);

$email = trim($_POST['email']);
$password = trim($_POST['password']);

session_start();
try {
	$user = $authController->login($email, $password);
	$_SESSION["userid"] = $user->id;

	redirect('/profile.php');
} catch (Exception $e) {
	$_SESSION['err'] = $e->getMessage();
	redirect('/login.php');
}

?>
