<?php
require_once('../config.php');

function page_end() { ?>
	</body>
	</html>
<?php }

function page_start($title) { ?>
	<!DOCTYPE html>
	<html lang="it">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?= TITLE ?> - <?= $title ?></title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
		<link rel="stylesheet" href="/style.css" />
		<link rel="stylesheet" href="/assets/icons/font/bootstrap-icons.css" />
	</head>
	<body>
<?php }
?>
