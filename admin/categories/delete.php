<?php
require_once '../../includes/init.php';
requireLogin();

$id = $_GET['id'] ?? null;

$stmt = $pdo->prepare("SELECT COUNT(*) FROM events WHERE category_id = :id");
$stmt->execute(['id' => $id]);

$count = $stmt->fetchColumn();

if ($count > 0) {
    die("Impossible de supprimer : des évenements sont associés à cette catégorie");
}

$stmt = $pdo->prepare("DELETE FROM categories WHERE id = :id");
$stmt->execute(['id' => $id]);

header('Location: index.php');
exit();