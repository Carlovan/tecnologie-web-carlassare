<nav class="navbar navbar-light bg-light fixed-top ps-3 pe-4">
	<a href="/" class="navbar-brand"><h1><?= TITLE ?></h1></a>
	<div class="text-end">
		<a href="/profile.php" class="nav-item p-2"><img src="/assets/icons/person-fill.svg" alt="Profile utente" /></a>
		<a href="/cart.php" class="nav-item p-2"><img src="/assets/icons/cart4.svg" alt="Carrello" /></a>
		<span class="nav-item dropdown">
			<a class="p-2" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
				<img src="/assets/icons/three-dots-vertical.svg" alt="Menu" />
			</a>
			<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
				<li><a class="dropdown-item" href="/sellers.php">Venditori</a></li>
				<li><a class="dropdown-item" href="/all-products.php">Tutti i prodotti</a></li>
			</ul>
		</span>
	</div>
	<form class="col-12 input-group" action="/search.php">
		<input type="search" class="form-control" name="q" placeholder="Cerca" title="Cerca" />
		<input type="submit" class="btn btn-outline-success" value="Cerca" />
	</form>
</nav>
