<?php
require_once '../../includes/init.php';
requireLogin();

$stmt = $pdo->query("SELECT * FROM categories");
$categories = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $imageName = null;

    if (!empty($_FILES['image']['name'])) {

        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

        if (!in_array($_FILES['image']['type'], $allowedTypes)) {
            die("Format non autorisé");
        }

        if ($_FILES['image']['size'] > 2 * 1024 * 1024) {
            die("Image trop lourde (max 2MB)");
        }

        $tmpName = $_FILES['image']['tmp_name'];
        $originalName = $_FILES['image']['name'];

        $imageName = time() . '_' . basename($originalName);

        move_uploaded_file($tmpName, '../../assets/images/events/' . $imageName);
    }

    $stmt = $pdo->prepare("
        INSERT INTO events 
        (titre, description, date, heure, lieux, adresse, prix, place_dispo, organisateur_nom, organisateur_email, image, category_id, user_id)
        VALUES 
        (:titre, :description, :date, :heure, :lieux, :adresse, :prix, :places, :orga_nom, :orga_email, :image, :category_id, :user_id)
    ");

    $stmt->execute([
        'titre' => $_POST['titre'],
        'description' => $_POST['description'],
        'date' => $_POST['date'],
        'heure' => $_POST['heure'],
        'lieux' => $_POST['lieux'],
        'adresse' => $_POST['adresse'],
        'prix' => $_POST['prix'],
        'places' => $_POST['places'],
        'orga_nom' => $_POST['orga_nom'],
        'orga_email' => $_POST['orga_email'],
        'image' => $imageName,
        'category_id' => $_POST['category_id'],
        'user_id' => $_SESSION['user']['id']
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
            <form method="POST" enctype="multipart/form-data">
                <input type="text" name="titre" placeholder="Titre" required>
                <textarea name="description" placeholder="Description"></textarea>
                <input type="date" name="date" required>
                <input type="time" name="heure" required>
                <input type="text" name="lieux" placeholder="Lieu">
                <input type="text" name="adresse" placeholder="Adresse">
                <input type="number" name="prix" placeholder="Prix">
                <input type="number" name="places" placeholder="Places disponibles">
                <input type="text" name="orga_nom" placeholder="Nom organisateur">
                <input type="email" name="orga_email" placeholder="Email organisateur">
                <input type="file" name="image" accept="image/*">
                <select name="category_id">
                    <?php foreach ($categories as $categorie): ?>
                        <option value="<?= $categorie['id'] ?>"><?= $categorie['nom'] ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit">Ajouter</button>
            </form>
        </section>
    </body>
</html>