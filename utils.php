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

function loggedUserOrRedirect($database, $redirect = '/login.php') {
	$user = loggedUser($database);
	if (is_null($user)) {
		redirect($redirect);
	}
	return $user;
}

function getUploadedImage($fieldName, $newName) {
    // Undefined | Multiple Files | $_FILES Corruption Attack
    // If this request falls under any of them, treat it invalid.
    if (!isset($_FILES[$fieldName]['error']) || is_array($_FILES[$fieldName]['error'])) {
        throw new RuntimeException('Parametri non validi');
    }

    switch ($_FILES[$fieldName]['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            throw new RuntimeException('File non presente');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            throw new RuntimeException("L'immagine è troppo grande");
        default:
            throw new RuntimeException('Errore sconosciuto');
    }

    if ($_FILES[$fieldName]['size'] > 1000000) {
        throw new RuntimeException("L'immagine è troppo grande");
    }

    // Check MIME Type
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    if (false === $ext = array_search(
        $finfo->file($_FILES[$fieldName]['tmp_name']),
        array(
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
        ),
        true
    )) {
        throw new RuntimeException('Formato non valido');
    }

	$finalName = $newName . '.' . $ext;
	$finalPath = IMAGES_D . $finalName;

    if (!move_uploaded_file($_FILES[$fieldName]['tmp_name'], $finalPath)) {
        throw new RuntimeException('Failed to move uploaded file.');
    }

	return WEB_IMGS_PATH . $finalName;
}

function isFileUploaded($fieldName) {
	return !empty($_FILES[$fieldName]['tmp_name']);
}

?>
