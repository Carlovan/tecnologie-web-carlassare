<?php
require_once(BACKEND_D . 'types/notification.php');

class NotificationsDatabase {
	private $database;
	public $tableName = 'notifications';

	function __construct($database) {
		$this->database = $database;
	}

	function initTable() {
		$this->database->users->initTable();

		$query = 
<<<QUERY
	CREATE TABLE IF NOT EXISTS {$this->tableName} (
		id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
		userId VARCHAR(50) NOT NULL,
		seen BOOLEAN NOT NULL DEFAULT FALSE,
		message TEXT NOT NULL,
		dateTime INT NOT NULL,
		CONSTRAINT fk_notif_user FOREIGN KEY (userId) REFERENCES {$this->database->users->tableName}(id)
	);
QUERY;

		if (!$this->database->conn()->query($query)) {
			echo "Errore creando notifications: ", $this->database->conn()->error;
		}
	}

	function getNewByUserId($userId) {
		$result = $this->database->query("SELECT * FROM {$this->tableName} WHERE seen = FALSE AND userId = ? ORDER BY dateTime ASC;",
			's', [$userId]);
		return array_map(function($row) { return new Notification($row); }, $result);
	}

	function setAllSeen($notifications) {
		if (count($notifications) == 0) {
			return;
		}
		$placeholders = implode(', ', array_fill(0, count($notifications), '?'));
		$placeholdersTypes = str_repeat('s', count($notifications));
		$placeholdersValues = array_map(function($n) { return $n->id; }, $notifications);
		$this->database->statement("UPDATE {$this->tableName} SET seen = TRUE WHERE id IN ($placeholders);", $placeholdersTypes, $placeholdersValues);
	}

	function add($notification) {
		$this->database->statement("INSERT INTO {$this->tableName}(userId, message, dateTime) VALUES (?, ?, ?);",
			'ssi', [$notification->userId, $notification->message, $notification->dateTime]);
	}
}

?>
