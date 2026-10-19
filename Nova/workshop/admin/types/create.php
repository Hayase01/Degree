<?php
require_once '../../config/admin_init.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom = trim($_POST['nom']);
    $couleur = trim($_POST['couleur']);

    if (!empty($nom) && !empty($couleur)) {

        $stmt = $pdo->prepare("
            INSERT INTO types
            (
                nom,
                couleur
            )
            VALUES
            (
                :nom,
                :couleur
            )
        ");

        $stmt->execute([
            'nom' => $nom,
            'couleur' => $couleur
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
    <title>Créer un type</title>

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
                placeholder="Nom du type"
                required
            >
            <label for="couleur">
                Couleur du type
            </label>
            <input
                type="color"
                id="couleur"
                name="couleur"
                value="#ffffff"
                required
            >
            <button type="submit">
                Ajouter
            </button>
        </form>
    </section>
</body>
</html>