<?php

function redirect($path) {
	header("Location: $path");
	exit();
}

function loggedUser($database) {
	if(!isset($_SESSION['userid'])) {
		return NULL;
	}
	return $database->users->get($_SESSION['userid']);
}
