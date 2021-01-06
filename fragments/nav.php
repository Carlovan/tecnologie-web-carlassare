<nav class="navbar navbar-light bg-light fixed-top ps-3 pe-4">
	<a href="/" class="navbar-brand"><h1><?= TITLE ?></h1></a>
	<div class="text-end order-lg-last">
		<span class="d-none d-lg-inline">
			<a class="nav-item text-decoration-none px-2 text-muted" href="/sellers.php">Venditori</a>
			<a class="nav-item text-decoration-none px-2 text-muted" href="/all-products.php">Tutti i prodotti</a>
		</span>
		<a href="/profile.php" class="nav-item p-2 text-decoration-none text-muted">
			<img src="/assets/icons/person-fill.svg" alt="Profilo utente" class="d-lg-none" />
			<span class="d-none d-lg-inline"> Profilo</span>
		</a>
		<a href="/cart.php" class="nav-item p-2 text-decoration-none text-muted">
			<img src="/assets/icons/cart4.svg" alt="Carrello" class="d-lg-none" />
			<span class="d-none d-lg-inline"> Carrello</span>
		</a>
		<div class="nav-item dropdown d-inline d-lg-none">
			<a class="p-2" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
				<img src="/assets/icons/three-dots-vertical.svg" alt="Menu" />
			</a>
			<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
				<li><a class="dropdown-item" href="/sellers.php">Venditori</a></li>
				<li><a class="dropdown-item" href="/all-products.php">Tutti i prodotti</a></li>
			</ul>
		</div>
	</div>
	<div class="col-12 col-lg-6">
		<form class="input-group" action="/search.php">
			<input type="search" class="form-control" name="q" placeholder="Cerca" title="Cerca" />
			<input type="submit" class="btn btn-outline-success" value="Cerca" />
		</form>
	</div>
</nav>
