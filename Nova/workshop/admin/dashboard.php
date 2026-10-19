<?php
require_once '../config/admin_init.php';
requireLogin();

$stmt = $pdo->query("SELECT COUNT(*) FROM produits");
$totalProduits = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM categories");
$totalCategories = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM types");
$totalTypes = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM commandes WHERE statut = 'En attente'");
$totalCommandes = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM commandes WHERE statut = 'Livree'");
$termineCommandes = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin</title>
        <link rel="stylesheet" href="../assets/css/reset.css">
        <link rel="stylesheet" href="../assets/css/admin.css">
    </head>
    <body>
        <section>
            <div class="admin-wrapper">
            <aside class="sidebar">
                <h2>Navigation</h2>
                <ul>
                    <li><a href="dashboard.php">Tableau de bord</a></li>
                    <li><a href="produits/index.php">Produits</a></li>
                    <li><a href="categories/index.php">Catégories</a></li>
                    <li><a href="types/index.php">Types</a></li>
                    <li><a href="commandes.php">Commandes</a></li>
                    <li><a href="../index.php">NOVA</a></li>
                    <li><a href="logout.php">Déconnexion</a></li>
                </ul>
            </aside>
            <main class="main-content">
                <div class="admin-header">
                    <h1>Statistiques</h1>
                </div>
                <div class="stats-container">
                    <div class="stat-card">
                        <p>Nombre de produits</p>
                        <h2><?= $totalProduits ?></h2>
                    </div>
                    <div class="stat-card">
                        <p>Nombre de catégories</p>
                        <h2><?= $totalCategories ?></h2>
                    </div>
                    <div class="stat-card">
                        <p>Nombre de types</p>
                        <h2><?= $totalTypes ?></h2>
                    </div>
                    <div class="stat-card">
                        <p>Nombre de commandes à effectuer</p>
                        <h2><?= $totalCommandes ?></h2>
                    </div>
                    <div class="stat-card">
                        <p>Nombre de commandes effectuées</p>
                        <h2><?= $termineCommandes ?></h2> 
                    </div>
                </div>
            </main>
        </section>
    </body>
</html>