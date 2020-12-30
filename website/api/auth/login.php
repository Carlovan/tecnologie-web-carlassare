<?php
require_once('../../../config.php');
require_once(MAIN_DIR . 'utils.php');
require_once(BACKEND_D . 'database.php');
require_once(BACKEND_D . 'controllers/auth.php');

$database = new Database();
$authController = new AuthController($database);

try {
	$user = $authController->login($_POST['email'], $_POST['password']);
	session_start();
	$_SESSION["userid"] = $user->id;

	redirect('/profile.php');
} catch (Exception $e) {
	redirect('/login.php?err=' . urlencode($e->getMessage()));
}

?>
