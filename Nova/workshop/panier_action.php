<?php

session_start();

if (!isset($_GET['action']) || !isset($_GET['cle'])) {
    header('Location: panier.php');
    exit();
}

$action = $_GET['action'];
$cle = $_GET['cle'];

if (!isset($_SESSION['panier'][$cle])) {
    header('Location: panier.php');
    exit();
}

switch ($action) {

    case 'plus':

        $_SESSION['panier'][$cle]['quantite']++;

        break;

    case 'moins':

        $_SESSION['panier'][$cle]['quantite']--;

        if ($_SESSION['panier'][$cle]['quantite'] <= 0) {
            unset($_SESSION['panier'][$cle]);
        }

        break;

    case 'delete':

        unset($_SESSION['panier'][$cle]);

        break;
}

header('Location: panier.php');
exit();