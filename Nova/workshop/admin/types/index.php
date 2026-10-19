<?php
require_once '../../config/admin_init.php';
requireLogin2();

$stmt = $pdo->query("SELECT * FROM types ORDER BY id_type ASC");
$types = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/admin.css">
</head>
<body>
    <section>
        <div class="admin-wrapper">
            <aside class="sidebar">
                <h2>Navigation</h2>
                <ul>
                    <li><a href="../dashboard.php">Tableau de bord</a></li>
                    <li><a href="../produits/index.php">Produits</a></li>
                    <li><a href="../categories/index.php">Catégories</a></li>
                    <li><a href="index.php">Types</a></li>
                    <li><a href="../commandes.php">Commandes</a></li>
                    <li><a href="../../index.php">NOVA</a></li>
                    <li><a href="../logout.php">Déconnexion</a></li>
                </ul>
            </aside>
            <main class="main-content">
                <div class="admin-header">
                    <h1>Gestion des types</h1>
                    <a href="create.php" class="btn">+ Ajouter un type</a>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nom</th>
                            <th>Couleur</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($types as $type): ?>
                            <tr>
                                <td><?= $type['id_type'] ?></td>
                                <td><?= htmlspecialchars($type['nom']) ?></td>
                                <td><?= $type['couleur'] ?? '—' ?></td>
                                <td class="actions">
                                    <a href="edit.php?id=<?= $type['id_type'] ?>" class="edit">
                                        <img src="../../assets/img/svg/edit.svg" alt="edit">
                                    </a>
                                    <a href="delete.php?id=<?= $type['id_type'] ?>" 
                                       onclick="return confirm('Supprimer ce type ?')" 
                                       class="delete">
                                        <img src="../../assets/img/svg/delete.svg" alt="delete">
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