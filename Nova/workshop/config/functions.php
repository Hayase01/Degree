<?php

function isLoggedIn() {
    return isset($_SESSION['user']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ../log.php');
        exit();
    }
}
function requireLogin2() {
    if (!isLoggedIn()) {
        header('Location: ../../log.php');
        exit();
    }
}
function isLogged(): bool
{
    return isset($_SESSION['user']);
}

function isAdmin(): bool
{
    return isset($_SESSION['user'])
        && $_SESSION['user']['role'] === 'admin';
}
?>