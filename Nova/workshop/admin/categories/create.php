<?php
require_once '../../config/admin_init.php';

requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $pdo->prepare("INSERT INTO categories (nom) VALUES (:nom)");
    $stmt->execute([
    'nom' => $_POST['nom'],
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
                <button type="submit">Ajouter</button>
            </form>
        </section>
    </body>
</html>