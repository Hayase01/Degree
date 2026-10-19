<?php
require_once '../config/init.php';
require_once '../config/admin_init.php';

session_destroy();

header('Location: ../log.php');
exit();
?>