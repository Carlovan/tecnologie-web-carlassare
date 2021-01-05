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
	<script>
		const toastTemplate = $(document.querySelector("template#toastTemplate").content.firstElementChild);
		function showToast(message) {
			const toastEl = toastTemplate.clone(true);
			toastEl.find(".toast-body").html(message);
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

		const updateNotificationsInterval = setInterval(updateNotifications, 10000);
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
