<?php
    require_once '../../config/admin_init.php';
    requireLogin();

    $id = $_GET['id'] ?? null;

    if (!$id || !is_numeric($id)) {
        die('Catégorie invalide');
    }

    $stmt = $pdo->prepare("
        SELECT *
        FROM categories
        WHERE id_category = :id
    ");

    $stmt->execute([
        'id' => $id
    ]);

    $category = $stmt->fetch();

    if (!$category) {
        die('Catégorie introuvable');
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $nom = trim($_POST['nom']);

        if (empty($nom)) {
            $error = 'Le nom est obligatoire';
        } else {

            $stmt = $pdo->prepare("
                UPDATE categories
                SET nom = :nom
                WHERE id_category = :id
            ");

            $stmt->execute([
                'nom' => $nom,
                'id' => $id
            ]);

            header('Location: index.php');
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Modifier une catégorie</title>

    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/log.css">

</head>

<body>

<section>

    <form method="POST">

        <h2>Modifier la catégorie</h2>

        <?php if (!empty($error)): ?>

            <p>
                <?= htmlspecialchars($error) ?>
            </p>

        <?php endif; ?>

        <input
            type="text"
            name="nom"
            value="<?= htmlspecialchars($category['nom']) ?>"
            required
        >

        <button type="submit">
            Mettre à jour
        </button>

    </form>

</section>

</body>
</html>