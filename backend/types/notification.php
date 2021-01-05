<?php

class Notification {
	public $id; // string
	public $userId; // string
	public $message; // string
	public $dateTime; // int
	public $seen; // bool

	function __construct($dataArray) {
		if (array_key_exists('id', $dataArray)) {
			$this->id = $dataArray['id'];
		}
		$this->userId = $dataArray['userId'];
		$this->message = $dataArray['message'];
		$this->dateTime = $dataArray['dateTime'];
		if (array_key_exists('seen', $dataArray)) {
			$this->seed = boolval($dataArray['seen']);
		}
	}
}

?>
