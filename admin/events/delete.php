<?php
require_once '../../includes/init.php';
requireLogin();

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    die("ID invalide");
}

$stmt = $pdo->prepare("DELETE FROM events WHERE id = :id");
$stmt->execute(['id' => $id]);

header('Location: index.php');
exit();
?>