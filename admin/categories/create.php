<?php
require_once '../../includes/init.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $pdo->prepare("INSERT INTO categories (nom, couleur) VALUES (:nom, :couleur)");
    $stmt->execute([
    'nom' => $_POST['nom'],
    'couleur' => $_POST['couleur']
    ]);
    
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Create</title>
        <link rel="stylesheet" href="../../assets/css/reset.css">
        <link rel="stylesheet" href="../../assets/css/log.css">
    </head>
    <body>
        <section>
            <form method="POST">
                <input type="text" name="nom" placeholder="Nom" required>
                <input type="text" name="couleur" placeholder="Couleur" required>
                <button type="submit">Ajouter</button>
            </form>
        </section>
    </body>
</html>