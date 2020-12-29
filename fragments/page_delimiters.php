<?php

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
		<link rel="stylesheet" href="/assets/bootstrap.min.css" />
		<link rel="stylesheet" href="/assets/icons/font/bootstrap-icons.css" />
		<link rel="stylesheet" href="/style.css" />
	</head>
	<body>
<?php }
?>
