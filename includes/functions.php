<?php

function isLoggedIn() {
    return isset($_SESSION['user']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit();
    }
}
function requireLogin2() {
    if (!isLoggedIn()) {
        header('Location: ../login.php');
        exit();
    }
}

?>