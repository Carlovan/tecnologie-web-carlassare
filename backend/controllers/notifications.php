<?php
require_once(BACKEND_D . 'types/notification.php');

class NotificationsController {
	private $database;

	function __construct($database) {
		$this->database = $database;
	}

	function send($userId, $message) {
		$this->database->notifications->add(new Notification(array(
			'userId' => $userId,
			'message' => $message,
			'dateTime' => time()
		)));
	}

	function get($user) {
		$result = $this->database->notifications->getNewByUserId($user->id);
		$this->database->notifications->setAllSeen($result);
		return $result;
	}
}

?>
