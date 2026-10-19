<?php

require_once '../../config/admin_init.php';
requireLogin();

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    die('ID produit invalide');
}

/*
|--------------------------------------------------------------------------
| Récupération du produit
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT image, image_banniere
    FROM produits
    WHERE id_produit = :id
");

$stmt->execute([
    'id' => $id
]);

$produit = $stmt->fetch();

if (!$produit) {
    die('Produit introuvable');
}

/*
|--------------------------------------------------------------------------
| Suppression des images
|--------------------------------------------------------------------------
*/

if (!empty($produit['image'])) {

    $imagePath =
        '../../assets/img/produits/' .
        $produit['image'];

    if (file_exists($imagePath)) {
        unlink($imagePath);
    }
}

if (!empty($produit['image_banniere'])) {

    $bannierePath =
        '../../assets/img/produits/' .
        $produit['image_banniere'];

    if (file_exists($bannierePath)) {
        unlink($bannierePath);
    }
}

/*
|--------------------------------------------------------------------------
| Suppression du produit
|--------------------------------------------------------------------------
|
| Les lignes de produit_format seront supprimées
| automatiquement grâce au ON DELETE CASCADE.
|
*/

$stmt = $pdo->prepare("
    DELETE FROM produits
    WHERE id_produit = :id
");

$stmt->execute([
    'id' => $id
]);

header('Location: index.php');
exit();