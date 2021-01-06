<?php

function page_end() { ?>
	<template id="toastTemplate">
		<div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
			<div class="d-flex align-items-center lead">
				<div class="toast-body"></div>
				<button type="button" class="btn-close ms-auto me-2" data-bs-dismiss="toast" aria-label="Close"></button>
			</div>
		</div>
	</template>
	<template id="modalTemplate">
		<div class="modal fade" tabindex="-1" aria-labelledby="modal-title" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h1 class="modal-title h5" id="modal-title"></h1>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body"></div>
					<div class="modal-footer modal-confirm">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
						<button type="button" class="btn btn-danger btn-callback">Conferma</button>
					</div>
					<div class="modal-footer modal-info">
						<button type="button" class="btn btn-primary" data-bs-dismiss="modal">Chiudi</button>
					</div>
				</div>
			</div>
		</div>
	</template>
	<script>
		function showToast(message, type) { // type is optional
			const toastTemplate = $(document.querySelector("template#toastTemplate").content.firstElementChild);
			const toastEl = toastTemplate.clone(true);
			toastEl.find(".toast-body").html(message);
			if (type === "danger") {
				toastEl.addClass('bg-danger text-white');
			} else if (type === "success") {
				toastEl.addClass('bg-success text-white').find('button').addClass('btn-close-white');
			}
			$('.toast-container').prepend(toastEl);
			const toast =  new bootstrap.Toast(toastEl.get(0), {autohide: false});
			toastEl.on('hidden.bs.toast', function() {
				toast.dispose();
				toastEl.remove();
			});
			toast.show();
		}

		function updateNotifications() {
			$.ajax({
				url: "/api/get-notifications.php",
				dataType: "json",
				cache: false
			})
			.done(function(data) {
				data.notifications.forEach(showToast);
			});
		}

		function showModal(title, message, type, callback) {
			const modalTemplate = $(document.querySelector("template#modalTemplate").content.firstElementChild);
			const modalEl = modalTemplate.clone(true);
			modalEl.find('.modal-title').html(title);
			modalEl.find('.modal-body').html(message);
			var buttonsSelector = '';
			if (type === undefined || type === 'info') {
				buttonsSelector = '.modal-info';
			} else if (type === 'confirm') {
				buttonsSelector = '.modal-confirm';
			}
			modalEl.find(buttonsSelector).siblings('.modal-footer').remove();
			modalEl.find('.btn-callback').on('click', callback);
			modalEl.prependTo('body');
			const modal = new bootstrap.Modal(modalEl.get(0), {});
			modalEl.on('hidden.bs.modal', function() {
				modal.dispose();
				modalEl.remove();
			});
			modal.show();
		}

		const updateNotificationsInterval = setInterval(updateNotifications, 10000);

<?php if (isset($_SESSION['err'])) { ?>
	showToast("<b>Si è verificato un errore: </b><?= $_SESSION['err'] ?>", "danger");
<?php
	unset($_SESSION['err']);
}

if (isset($_SESSION['info'])) { ?>
	showToast("<?= $_SESSION['info'] ?>", "success");
<?php
	unset($_SESSION['info']);
}
?>
	</script>
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
		<script src="/assets/bootstrap.bundle.min.js"></script>
		<script src="/assets/jquery.min.js"></script>
	</head>
	<body>
	<div class="toast-container mt-4 px-3 fixed-top"></div>
<?php }
?>
