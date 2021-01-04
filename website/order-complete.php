<?php
require_once('../config.php');
require_once(MAIN_DIR . 'utils.php');
require_once(FRAGS_D . 'page_delimiters.php');
require_once(BACKEND_D . 'database.php');

session_start();

$database = new Database();
$user = loggedUserOrRedirect($database);

$entries = $database->cart->byUserId($user->id);
if (empty($entries)) {
	redirect('/');
}

foreach ($entries as $entry) {
	$database->cart->remove($entry->productId, $entry->userId);
}

page_start('Ordine');
require(FRAGS_D . 'nav.php');
?>
	<main class="mt-nav text-center">
		<section>
			<img src="/assets/images/shipping.gif" alt="La spedizione verrà effettuata a breve" class="w-100" />
			<h1 class="text-success display-1">Ordine completato!</h1>
			<h2 class="display-4 text-muted mx-3">La spedizione verrà effettuata al più presto</h2>
		</section>
	</main>
	<section class="text-center mt-5">
		<a href="/" role="button" class="btn btn-success"><i class="bi-arrow-bar-left"></i> Torna alla homepage</a>
	</section>
<?php
page_end();
?>
