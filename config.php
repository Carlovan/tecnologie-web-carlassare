<?php

define('TITLE', "Negozio");
define('QUANTITY_ALERT', 5);

define('WEB_IMGS_PATH', '/assets/images/');

// Directories
define('MAIN_DIR', __DIR__ . '/');
define('BACKEND_D', MAIN_DIR . 'backend/');
define('FRAGS_D', MAIN_DIR . 'fragments/');
define('WEBSITE_D', MAIN_DIR . 'website/');
define('IMAGES_D', realpath(WEBSITE_D . WEB_IMGS_PATH) . '/');

define('DB_HOST', 'localhost');
define('DB_USER', 'sito_u');
define('DB_PASS', 'password');
define('DB_NAME', 'sito_db');

?>
