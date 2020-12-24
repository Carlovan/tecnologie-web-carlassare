<?php
require_once('../config.php');
?>
<nav class="navbar navbar-light bg-light fixed-top ps-3 pe-4">
	<a href="/" class="navbar-brand"><h1><?= TITLE ?></h1></a>
	<div class="text-end">
		<a href="" class="nav-item p-2"><img src="assets/icons/person-fill.svg" alt="Profile utente" /></a>
		<a href="" class="nav-item p-2"><img src="assets/icons/cart4.svg" alt="Carrello" /></a>
		<a href="" class="nav-item p-2"><img src="assets/icons/three-dots-vertical.svg" alt="menu" /></a>
	</div>
	<form class="col-12 input-group">
		<input type="search" class="form-control" name="q" placeholder="Cerca" title="Cerca" />
		<input type="submit" class="btn btn-outline-success" value="Cerca" />
	</form>
</nav>
