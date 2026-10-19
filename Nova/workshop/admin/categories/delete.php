<?php
require_once '../../config/admin_init.php';
requireLogin();

$id = $_GET['id'] ?? null;

$stmt = $pdo->prepare("SELECT COUNT(*) FROM produits WHERE id_category = :id");
$stmt->execute(['id' => $id]);

$count = $stmt->fetchColumn();

if ($count > 0) {
    die("Impossible de supprimer : des produits sont associés à cette catégorie");
}

$stmt = $pdo->prepare("DELETE FROM categories WHERE id_category = :id");
$stmt->execute(['id' => $id]);

header('Location: index.php');
exit();