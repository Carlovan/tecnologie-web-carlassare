<?php

class UsersDatabase {
	private $users = NULL;
	private $filename = DB_D . 'users.db';

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

	function get($id) {
		$this->loadData();

		foreach ($this->users as $user) {
			if ($user->id === $id) {
				return $user;
			}
		}
		return NULL;
	}

	function byEmail($email) {
		$this->loadData();

		foreach ($this->users as $user) {
			if ($user->email === $email) {
				return $user;
			}
		}
		return NULL;
	}

	function add($user) {
		$this->loadData();
		if (is_null($user->id)) {
			$user->id = count($this->users);
		}
		$this->users[] = $user;
		$this->saveData();
		return $user->id;
	}

	function update($user) {
		$this->loadData();

		foreach ($this->users as $k => $u) {
			if ($u->id === $user->id) {
				$this->users[$k] = $user;
				break;
			}
		}

		$this->saveData();
	}
}

?>
