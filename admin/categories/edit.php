<?php
require_once '../../includes/init.php';
requireLogin();

$id = $_GET['id'] ?? null;

$stmt = $pdo->prepare("SELECT * FROM categories WHERE id = :id");
$stmt->execute(['id' => $id]);

$category = $stmt->fetch();

if (!$category) {
    die("Catégorie introuvable");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom = trim($_POST['nom']);

    if (!empty($nom)) {
        $stmt = $pdo->prepare("
        UPDATE categories 
        SET nom = :nom, couleur = :couleur 
        WHERE id = :id
        ");

        $stmt->execute([
        'nom' => $_POST['nom'],
        'couleur' => $_POST['couleur'],
        'id' => $id
    ]);

        header('Location: index.php');
        exit();
    } else {
        $error = "Le nom est obligatoire";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit</title>
        <link rel="stylesheet" href="../../assets/css/reset.css">
        <link rel="stylesheet" href="../../assets/css/log.css">
    </head>
    <body>
        <section>
            <form method="POST">
                <input type="text" name="nom" value="<?= $category['nom'] ?>" required>
                <input type="text" name="couleur" value="<?= $category['couleur'] ?>" required>
                <button type="submit">Mettre à jour</button>
            </form>      
        </section>
    </body>
</html>


