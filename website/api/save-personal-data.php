<?php
require_once('../../config.php');
require_once(MAIN_DIR . 'utils.php');
require_once(BACKEND_D . 'database.php');
require_once(BACKEND_D . 'controllers/users.php');

session_start();

$database = new Database();
$usersController = new UsersController();
$user = loggedUserOrRedirect($database);

$email = trim($_POST['email']);
$name = trim($_POST['name']);
$newPassword = trim($_POST['new-password']);
$oldPassword = trim($_POST['old-password']);

try {
	$usersController->validateData($name, $email);
	if ($email !== $user->email && !is_null($database->users->byEmail($email))) {
		throw new InvalidArgumentException("L'indirizzo email specificato è già in uso");
	}

	$user->email = $email;
	$user->name = $name;

	if (!empty($newPassword) || !empty($oldPassword)) {
		$usersController->validatePassword($newPassword);
		if (!password_verify($oldPassword, $user->passwordHash)) {
			throw new InvalidArgumentException("La password attuale non è corretta");
		}

		$user->passwordHash = $usersController->passwordHash($newPassword);
		$_SESSION['info'] = 'Password modificata correttamente';
	}

	$database->users->update($user);
	if (!isset($_SESSION['info'])) {
		$_SESSION['info'] = '';
	}
	$_SESSION['info'] .= "Modifiche salvate correttamente";
} catch (Exception $e) {
	$_SESSION['err'] = $e->getMessage();
}

redirect('/profile/personaldata.php');
?>
