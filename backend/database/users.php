<?php

class UsersDatabase {
	private $users = NULL;
	private $filename = 'users.db';

	private function loadData() {
		if (is_null($this->users)) {
			$this->users = unserialize(file_get_contents($this->filename));
			if ($this->users === false) {
				$this->users = array();
				$this->saveData();
			}
		}
	}
	private function saveData() {
		file_put_contents($this->filename, serialize($this->users));
	}

	function byEmail($email) {
		$this->loadData();

		$users = array_filter($this->users, function($u) { return $u->email == $email; });
		if (count($users) === 0) {
			return NULL;
		}
		return $users[0];
	}

	function add($user) {
		$this->loadData();
		if (is_null($user->id)) {
			$user->id = count($this->users);
		}
		$this->users[] = $user;
		$this->saveData();
	}
}

?>
