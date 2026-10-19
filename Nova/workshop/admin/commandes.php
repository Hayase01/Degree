<?php
require_once '../config/admin_init.php';
requireLogin();

$stmt = $pdo->query("
    SELECT *
    FROM commandes
    ORDER BY date_commande DESC
");

$commandes = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Gestion des commandes</title>

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
                    <h1>Gestion des commandes</h1>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Client</th>
                            <th>Email</th>
                            <th>Date</th>
                            <th>Montant</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($commandes as $commande): ?>
                        <tr>
                            <td>
                                <?= $commande['id_commande'] ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($commande['prenom_client']) ?>
                                <?= htmlspecialchars($commande['nom_client']) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($commande['email_client']) ?>
                            </td>
                            <td>
                                <?= date('d/m/Y H:i', strtotime($commande['date_commande'])) ?>
                            </td>
                            <td>
                                <?= number_format($commande['montant_total'], 2, ',', ' ') ?>
                                €
                            </td>
                            <td>
                                <?= htmlspecialchars($commande['statut']) ?>
                            </td>
                            <td>
                                <a href="commande_edit.php?id=<?= $commande['id_commande'] ?>">
                                    Modifier
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </main>
        </div>
    </section>
</body>
</html>