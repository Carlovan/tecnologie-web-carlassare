<?php
require_once('../../config.php');
require_once(BACKEND_D . 'database.php');

$database = new Database();
$database->initDb();
echo "DONE";

?>
