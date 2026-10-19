<?php
require_once '../../config/admin_init.php';
requireLogin2();

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) { $page = 1; }

$limit = 5;
$offset = ($page - 1) * $limit;

$filter = $_GET['filter'] ?? 'tous';
$allowed_filters = ['tous', 'produits', 'shakers'];
if (!in_array($filter, $allowed_filters)) {
    $filter = 'tous';
}

$where = "";
if ($filter === 'produits') {
    $where = "WHERE categories.nom = 'Produit'"; 
} elseif ($filter === 'shakers') {
    $where = "WHERE categories.nom = 'Shaker'";
}

// 1. REQUÊTE RECTIFIÉE : id_produit correspond exactement à votre schéma SQL
// Utilisation de MIN() pour afficher le prix le plus bas si le produit possède plusieurs formats.
$sql_produits = "
    SELECT 
        produits.*, 
        categories.nom AS categorie, 
        types.nom AS nom_type,
        MIN(produit_format.prix) AS prix_min
    FROM produits 
    JOIN categories ON produits.id_category = categories.id_category
    LEFT JOIN types ON produits.id_type = types.id_type
    LEFT JOIN produit_format ON produits.id_produit = produit_format.id_produit
    $where 
    GROUP BY produits.id_produit
    ORDER BY produits.id_produit ASC 
    LIMIT :limit OFFSET :offset
";

$stmt = $pdo->prepare($sql_produits);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$produits = $stmt->fetchAll();

// 2. COMPTEUR SÉCURISÉ : COUNT(DISTINCT) évite de multiplier le total par le nombre de formats
$sql_total = "
    SELECT COUNT(DISTINCT produits.id_produit) as total 
    FROM produits
    JOIN categories ON produits.id_category = categories.id_category
    LEFT JOIN types ON produits.id_type = types.id_type
    LEFT JOIN produit_format ON produits.id_produit = produit_format.id_produit
    $where
";

$stmt_total = $pdo->prepare($sql_total);
$stmt_total->execute();

$total = $stmt_total->fetch()['total'];
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
                    <li><a href="index.php">Produits</a></li>
                    <li><a href="../categories/index.php">Catégories</a></li>
                    <li><a href="../types/index.php">Types</a></li>
                    <li><a href="../commandes.php">Commandes</a></li>
                    <li><a href="../../index.php">NOVA</a></li>
                    <li><a href="../logout.php">Déconnexion</a></li>
                </ul>
            </aside>
            <main class="main-content">
                <div class="admin-header">
                    <h1>Gestion des produits</h1>
                    <a href="create.php" class="btn">+ Ajouter un produit</a>
                </div>
                <div class="filters">
                    <a href="?filter=tous" class="<?= $filter === 'tous' ? 'active' : '' ?>">Tous</a>
                    <a href="?filter=produits" class="<?= $filter === 'produits' ? 'active' : '' ?>">Produits</a>
                    <a href="?filter=shakers" class="<?= $filter === 'shakers' ? 'active' : '' ?>">Shakers</a>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Titre</th>
                            <th>Description</th>
                            <th>Catégorie</th>
                            <th>Types</th>
                            <th>Prix (à partir de)</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produits as $produit): ?>
                        <tr>
                            <td><?= htmlspecialchars($produit['id_produit']) ?></td>
                            <td><?= htmlspecialchars($produit['nom']) ?></td>
                            <td><?= htmlspecialchars($produit['description']) ?></td>
                            <td><?= htmlspecialchars($produit['categorie']) ?></td>
                            <td><?= htmlspecialchars($produit['nom_type'] ?? 'Aucun') ?></td>
                            <td>
                                <?php if ($produit['prix_min'] !== null): ?>
                                    <?= htmlspecialchars(number_format($produit['prix_min'], 2, ',', ' ')) ?> €
                                <?php else: ?>
                                    Pas de prix défini
                                <?php endif; ?>
                            </td>
                            <td class="actions">
                                <a href="edit.php?id=<?= $produit['id_produit'] ?>"><img src="../../assets/img/svg/edit.svg" alt="modifier"></a>
                                <a href="delete.php?id=<?= $produit['id_produit'] ?>" onclick="return confirm('Supprimer ce produit ?')"><img src="../../assets/img/svg/delete.svg" alt="supprimer"></a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a class="<?= $i == $page ? 'active' : '' ?>" href="?filter=<?= urlencode($filter) ?>&page=<?= $i ?>"><?= $i ?></a>
                    <?php endfor; ?>
                </div>
            </main>
        </div>
    </section>   
</body>
</html>
