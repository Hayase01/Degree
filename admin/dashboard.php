<?php
require_once '../includes/init.php';
requireLogin();

$stmt = $pdo->query("SELECT COUNT(*) FROM events");
$totalEvents = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM events WHERE date >= CURDATE()");
$eventsAvenir = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM events WHERE date < CURDATE()");
$eventsPasse = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM categories");
$totalCategories = $stmt->fetchColumn();
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
                    <li><a href="events/index.php">Événements</a></li>
                    <li><a href="categories/index.php">Catégories</a></li>
                    <li><a href="logout.php">Déconnexion</a></li>
                </ul>
            </aside>
            <main class="main-content">
                <div class="admin-header">
                    <h1>Statistiques</h1>
                </div>
                <div class="stats-container">
                    <div class="stat-card">
                        <p>Nombre d'événements</p>
                        <h2><?= $totalEvents ?></h2>
                    </div>
                    <div class="stat-card">
                        <p>Nombre d'événements à venir</p>
                        <h2><?= $eventsAvenir ?></h2>
                    </div>
                    <div class="stat-card">
                        <p>Nombre d'événements passés</p>
                        <h2><?= $eventsPasse ?></h2>
                    </div>
                    <div class="stat-card">
                        <p>Nombre de catégories</p>
                        <h2><?= $totalCategories ?></h2>
                    </div>
            </div>
            </main>
        </section>
    </body>
</html>

