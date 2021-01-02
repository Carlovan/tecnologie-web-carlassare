<?php
if (isset($_SESSION['err'])) { ?>
	<div class="alert alert-danger mx-3" role="alert">
		<b>Si è verificato un errore: </b><?= $_SESSION['err'] ?>
	</div>
<?php
	unset($_SESSION['err']);
}

if (isset($_SESSION['info'])) { ?>
	<div class="alert alert-success mx-3" role="alert">
		<?= $_SESSION['info'] ?>
	</div>
<?php
	unset($_SESSION['info']);
}
?>
