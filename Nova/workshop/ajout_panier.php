<?php
    session_start();
    require_once 'config/init.php';
    
    $idProduit = $_POST['id_produit'] ?? null;
    $idFormat = $_POST['id_format'] ?? null;
    
    if (!$idProduit || !$idFormat) {
        header('Location: index.php');
        exit();
    }
    
    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = [];
    }
    
    $cle = $idProduit . '_' . $idFormat;
    
    if (isset($_SESSION['panier'][$cle])) {
    
        $_SESSION['panier'][$cle]['quantite']++;
    
    } else {
    
        $_SESSION['panier'][$cle] = [
            'id_produit' => $idProduit,
            'id_format' => $idFormat,
            'quantite' => 1
        ];
    }
    
    header('Location: produit.php?id=' . $idProduit);
    exit();
?>