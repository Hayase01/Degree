<?php

require_once '../../config/admin_init.php';
requireLogin();

$stmt = $pdo->query("SELECT * FROM categories ORDER BY nom");
$categories = $stmt->fetchAll();

$stmt = $pdo->query("SELECT * FROM types ORDER BY nom");
$types = $stmt->fetchAll();

$stmt = $pdo->query("SELECT * FROM formats ORDER BY id_format");
$formats = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $imageName = null;
    $banniereName = null;

    $allowedTypes = [
        'image/jpeg',
        'image/png',
        'image/webp'
    ];

    /*
    |--------------------------------------------------------------------------
    | IMAGE PRINCIPALE
    |--------------------------------------------------------------------------
    */

    if (!empty($_FILES['image']['name'])) {

        if (!in_array($_FILES['image']['type'], $allowedTypes)) {
            die('Format image non autorisé');
        }

        if ($_FILES['image']['size'] > 2 * 1024 * 1024) {
            die('Image trop lourde');
        }

        $imageName =
            time() .
            '_img_' .
            basename($_FILES['image']['name']);

        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            '../../assets/img/produits/' . $imageName
        );
    }

    /*
    |--------------------------------------------------------------------------
    | BANNIERE
    |--------------------------------------------------------------------------
    */

    if (!empty($_FILES['image_banniere']['name'])) {

        if (!in_array($_FILES['image_banniere']['type'], $allowedTypes)) {
            die('Format bannière non autorisé');
        }

        if ($_FILES['image_banniere']['size'] > 2 * 1024 * 1024) {
            die('Bannière trop lourde');
        }

        $banniereName =
            time() .
            '_ban_' .
            basename($_FILES['image_banniere']['name']);

        move_uploaded_file(
            $_FILES['image_banniere']['tmp_name'],
            '../../assets/img/produits/' . $banniereName
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SLUG
    |--------------------------------------------------------------------------
    */

    $slug = strtolower(trim($_POST['titre']));
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    $slug = trim($slug, '-');

    /*
    |--------------------------------------------------------------------------
    | PRODUIT
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare("
        INSERT INTO produits
        (
            nom,
            slug,
            description,
            image,
            image_banniere,
            id_category,
            id_type
        )
        VALUES
        (
            :nom,
            :slug,
            :description,
            :image,
            :image_banniere,
            :id_category,
            :id_type
        )
    ");

    $stmt->execute([
        'nom' => $_POST['titre'],
        'slug' => $slug,
        'description' => $_POST['description'],
        'image' => $imageName,
        'image_banniere' => $banniereName,
        'id_category' => $_POST['id_category'],
        'id_type' => !empty($_POST['id_type'])
            ? $_POST['id_type']
            : null
    ]);

    $idProduit = $pdo->lastInsertId();

    /*
    |--------------------------------------------------------------------------
    | FORMATS
    |--------------------------------------------------------------------------
    */

    if (!empty($_POST['formats'])) {

        $stmtFormat = $pdo->prepare("
            INSERT INTO produit_format
            (
                id_produit,
                id_format,
                prix,
                stock
            )
            VALUES
            (
                :id_produit,
                :id_format,
                :prix,
                :stock
            )
        ");

        foreach ($_POST['formats'] as $idFormat) {

            $stmtFormat->execute([
                'id_produit' => $idProduit,
                'id_format' => $idFormat,
                'prix' => $_POST['prix'][$idFormat] ?? 0,
                'stock' => $_POST['stock'][$idFormat] ?? 0
            ]);
        }
    }

    header('Location: index.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un produit</title>

    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/log.css">
</head>

<body>

<section>

<form method="POST" enctype="multipart/form-data">

    <input
        type="text"
        name="titre"
        placeholder="Nom du produit"
        required
    >

    <textarea
        name="description"
        placeholder="Description"
    ></textarea>

    <label>Image principale</label>

    <input
        type="file"
        name="image"
        accept="image/*"
    >

    <label>Bannière</label>

    <input
        type="file"
        name="image_banniere"
        accept="image/*"
    >

    <label>Catégorie</label>

    <select name="id_category" required>

        <?php foreach ($categories as $categorie): ?>

            <option value="<?= $categorie['id_category'] ?>">
                <?= htmlspecialchars($categorie['nom']) ?>
            </option>

        <?php endforeach; ?>

    </select>

    <label>Type</label>

    <select name="id_type">

        <option value="">
            Aucun
        </option>

        <?php foreach ($types as $type): ?>

            <option value="<?= $type['id_type'] ?>">
                <?= htmlspecialchars($type['nom']) ?>
            </option>

        <?php endforeach; ?>

    </select>

    <hr>

    <h3>Formats disponibles</h3>

    <?php foreach ($formats as $format): ?>

        <div style="margin-bottom:15px;">

            <label>

                <input
                    type="checkbox"
                    name="formats[]"
                    value="<?= $format['id_format'] ?>"
                >

                <?= htmlspecialchars($format['libelle']) ?>

            </label>

            <input
                type="number"
                step="0.01"
                name="prix[<?= $format['id_format'] ?>]"
                placeholder="Prix"
            >

            <input
                type="number"
                name="stock[<?= $format['id_format'] ?>]"
                placeholder="Stock"
            >

        </div>

    <?php endforeach; ?>

    <button type="submit">
        Ajouter le produit
    </button>

</form>

</section>

</body>
</html>