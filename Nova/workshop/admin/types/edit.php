<?php
    require_once '../../config/admin_init.php';
    requireLogin();

    $id = $_GET['id'] ?? null;

    if (!$id || !is_numeric($id)) {
        die("Type invalide");
    }

    $stmt = $pdo->prepare("
        SELECT *
        FROM types
        WHERE id_type = :id
    ");

    $stmt->execute([
        'id' => $id
    ]);

    $type = $stmt->fetch();

    if (!$type) {
        die("Type introuvable");
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $nom = trim($_POST['nom']);
        $couleur = trim($_POST['couleur']);

        if (!empty($nom) && !empty($couleur)) {

            $stmt = $pdo->prepare("
                UPDATE types
                SET
                    nom = :nom,
                    couleur = :couleur
                WHERE id_type = :id
            ");

            $stmt->execute([
                'nom' => $nom,
                'couleur' => $couleur,
                'id' => $id
            ]);

            header('Location: index.php');
            exit();
        }

        $error = "Tous les champs sont obligatoires.";
    }
?>

<!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Modifier un type</title>

        <link rel="stylesheet" href="../../assets/css/reset.css">
        <link rel="stylesheet" href="../../assets/css/log.css">
    </head>

    <body>
        <section>
            <form method="POST">
                <?php if (!empty($error)): ?>
                    <p><?= htmlspecialchars($error) ?></p>
                <?php endif; ?>
                <input
                    type="text"
                    name="nom"
                    value="<?= htmlspecialchars($type['nom']) ?>"
                    required
                >
                <input
                    type="color"
                    name="couleur"
                    value="<?= htmlspecialchars($type['couleur']) ?>"
                    required
                >
                <button type="submit">
                    Mettre à jour
                </button>
            </form>
        </section>
    </body>
</html>