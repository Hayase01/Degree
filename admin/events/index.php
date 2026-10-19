<?php
require_once '../../includes/init.php';
requireLogin2();

$filter = $_GET['filter'] ?? 'tous';

$where = "";

if ($filter === 'avenir') {
    $where = "WHERE Date >= CURDATE()";
} elseif ($filter === 'passe') {
    $where = "WHERE Date < CURDATE()";
}

$page = $_GET['page'] ?? 1;
$limit = 5;
$offset = ($page - 1) * $limit;

$stmt = $pdo->query("
    SELECT events.*, categories.nom AS categorie
    FROM events
    JOIN categories ON events.category_id = categories.id
    $where
    ORDER BY Date ASC
    LIMIT $limit OFFSET $offset
");

$events = $stmt->fetchAll();

$stmt = $pdo->query("
    SELECT COUNT(*) as total 
    FROM events 
    $where
");

$total = $stmt->fetch()['total'];
$totalPages = ceil($total / $limit);

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
                    <li><a href="index.php">Événements</a></li>
                    <li><a href="../categories/index.php">Catégories</a></li>
                    <li><a href="../logout.php">Déconnexion</a></li>
                </ul>
            </aside>
            <main class="main-content">
                <div class="admin-header">
                    <h1>Gestion des évenements</h1>
                    <a href="create.php" class="btn">+ Ajouter un événement</a>
                </div>
                <div class="filters">
                    <a href="?filter=tous" class="<?= $filter === 'tous' ? 'active' : '' ?>">Tous</a>
                    <a href="?filter=avenir" class="<?= $filter === 'avenir' ? 'active' : '' ?>">À venir</a>
                    <a href="?filter=passe" class="<?= $filter === 'passe' ? 'active' : '' ?>">Passé</a>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Titre</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Heure</th>
                            <th>Adresse</th>
                            <th>Catégorie</th>
                            <th>Prix</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($events as $event): ?>
                        <tr>
                            <td><?= $event['id'] ?></td>
                            <td><?= $event['titre'] ?></td>
                            <td><?= $event['description'] ?></td>
                            <td><?= date('d-m-Y', strtotime($event['date'])) ?></td>
                            <td><?= $event['heure'] ?></td>
                            <td><?= $event['adresse'] ?></td>
                            <td><?= $event['categorie'] ?></td>
                            <td><?= $event['prix'] ?></td>
                            <td class="actions">
                                <a href="edit.php?id=<?= $event['id'] ?>"><img src="..\..\assets\images\svg\edit.svg" alt="edit"></a>
                                <a href="delete.php?id=<?= $event['id'] ?>"onclick="return confirm('Supprimer cet événement ?')"><img src="..\..\assets\images\svg\delete.svg" alt="delete"></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a class="<?= $i == $page ? 'active' : '' ?>" href="?filter=<?= $filter ?>&page=<?= $i ?>"><?= $i ?></a>
                    <?php endfor; ?>
                </div>
            </main>
        </div>
    </section>   
</body>
</html>