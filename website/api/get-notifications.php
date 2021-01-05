<?php
require_once('../../config.php');
require_once(MAIN_DIR . 'utils.php');
require_once(BACKEND_D . 'database.php');

session_start();

$database = new Database();
$user = loggedUser($database);

$messages = [];
if (!is_null($user)) {
	$notifications = $database->notifications->getNewByUserId($user->id);
	$messages = array_map(function($n) { return $n->message; }, $notifications);
	$database->notifications->setAllSeen($notifications);
}

header('Content-type: application/json');
echo json_encode(array(
	"notifications" => $messages
));

?>
