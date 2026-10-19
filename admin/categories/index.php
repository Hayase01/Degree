<?php
require_once '../../includes/init.php';
requireLogin2();

$stmt = $pdo->query("SELECT * FROM categories ORDER BY id ASC");
$categories = $stmt->fetchAll();
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
                    <li><a href="../events/index.php">Événements</a></li>
                    <li><a href="index.php">Catégories</a></li>
                    <li><a href="../logout.php">Déconnexion</a></li>
                </ul>
            </aside>
            <main class="main-content">
                <div class="admin-header">
                    <h1>Gestion des catégories</h1>
                    <a href="create.php" class="btn">+ Ajouter une catégorie</a>
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
                        <?php foreach ($categories as $cat): ?>
                            <tr>
                                <td><?= $cat['id'] ?></td>
                                <td><?= htmlspecialchars($cat['nom']) ?></td>
                                <td><?= $cat['couleur'] ?? '—' ?></td>
                                <td class="actions">
                                    <a href="edit.php?id=<?= $cat['id'] ?>" class="edit">
                                        <img src="../../assets/images/svg/edit.svg" alt="edit">
                                    </a>
                                    <a href="delete.php?id=<?= $cat['id'] ?>" 
                                       onclick="return confirm('Supprimer cette catégorie ?')" 
                                       class="delete">
                                        <img src="../../assets/images/svg/delete.svg" alt="delete">
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