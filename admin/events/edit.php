<?php
require_once '../../includes/init.php';
requireLogin();

$id = $_GET['id'] ?? null;

$stmt = $pdo->prepare("SELECT * FROM events WHERE id = :id");
$stmt->execute(['id' => $id]);
$event = $stmt->fetch();

if (!$event) {
    die("Event introuvable");
}

$stmt = $pdo->query("SELECT * FROM categories");
$categories = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $imageName = $event['image'];

    if (!empty($_FILES['image']['name'])) {

        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];

        if (!in_array($_FILES['image']['type'], $allowedTypes)) {
            die("Format non autorisé");
        }

        if ($_FILES['image']['size'] > 2 * 1024 * 1024) {
            die("Image trop lourde");
        }

        $tmpName = $_FILES['image']['tmp_name'];
        $imageName = time() . '_' . basename($_FILES['image']['name']);

        move_uploaded_file($tmpName, '../../assets/images/events/' . $imageName);
    }

    $stmt = $pdo->prepare("
        UPDATE events SET
            titre = :titre,
            description = :description,
            date = :date,
            heure = :heure,
            lieux = :lieux,
            adresse = :adresse,
            prix = :prix,
            place_dispo = :place_dispo,
            organisateur_nom = :organisateur_nom,
            organisateur_email = :organisateur_email,
            image = :image,
            category_id = :category_id
        WHERE id = :id
    ");

    $stmt->execute([
        'titre' => $_POST['titre'],
        'description' => $_POST['description'],
        'date' => $_POST['date'],
        'heure' => $_POST['heure'],
        'lieux' => $_POST['lieux'],
        'adresse' => $_POST['adresse'],
        'prix' => $_POST['prix'],
        'place_dispo' => $_POST['place_dispo'],
        'organisateur_nom' => $_POST['organisateur_nom'],
        'organisateur_email' => $_POST['organisateur_email'],
        'image' => $imageName,
        'category_id' => $_POST['category_id'],
        'id' => $id
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
        <title>Edit</title>
        <link rel="stylesheet" href="../../assets/css/reset.css">
        <link rel="stylesheet" href="../../assets/css/log.css">
    </head>
<body>
    <section>
        <form method="POST" enctype="multipart/form-data">
            <input type="text" name="titre" value="<?= $event['titre'] ?>" required>
            <textarea name="description"><?= $event['description'] ?></textarea>
            <input type="date" name="date" value="<?= $event['date'] ?>" required>
            <input type="time" name="heure" value="<?= $event['heure'] ?>" required>
            <input type="text" name="lieux" value="<?= $event['lieux'] ?>">
            <input type="text" name="adresse" value="<?= $event['adresse'] ?>">
            <input type="number" name="prix" value="<?= $event['prix'] ?>">
            <input type="number" name="place_dispo" value="<?= $event['place_dispo'] ?>">
            <input type="text" name="organisateur_nom" value="<?= $event['organisateur_nom'] ?>">
            <input type="email" name="organisateur_email" value="<?= $event['organisateur_email'] ?>">
            <img src="../../assets/images/events/<?= $event['image'] ?>" width="100">
            <input type="file" name="image">
            <select name="category_id">
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>"
                        <?= $cat['id'] == $event['category_id'] ? 'selected' : '' ?>>
                        <?= $cat['nom'] ?>
                    </option>
                <?php endforeach; ?>
            </select>                 
            <button type="submit">Mettre à jour</button>
        </form>
    </section>
</body>
</html>