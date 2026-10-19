<?php

    require_once '../../config/admin_init.php';
    requireLogin();

    $id = $_GET['id'] ?? null;

    if (!$id || !is_numeric($id)) {
        die('Produit invalide');
    }

    $stmt = $pdo->prepare("
        SELECT *
        FROM produits
        WHERE id_produit = :id
    ");

    $stmt->execute([
        'id' => $id
    ]);

    $produit = $stmt->fetch();

    if (!$produit) {
        die('Produit introuvable');
    }


    $categories = $pdo->query("
        SELECT *
        FROM categories
        ORDER BY nom
    ")->fetchAll();

    $types = $pdo->query("
        SELECT *
        FROM types
        ORDER BY nom
    ")->fetchAll();

    $formats = $pdo->query("
        SELECT *
        FROM formats
        ORDER BY id_format
    ")->fetchAll();

    $stmt = $pdo->prepare("
        SELECT *
        FROM produit_format
        WHERE id_produit = :id
    ");

    $stmt->execute([
        'id' => $id
    ]);

    $formatsProduit = [];

    foreach ($stmt->fetchAll() as $ligne) {

        $formatsProduit[$ligne['id_format']] = [
            'prix' => $ligne['prix'],
            'stock' => $ligne['stock']
        ];
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $image = $produit['image'];
        $image_banniere = $produit['image_banniere'];

        $allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/webp'
        ];

        if (!empty($_FILES['image']['name'])) {

            if (
                in_array(
                    $_FILES['image']['type'],
                    $allowedTypes
                )
            ) {

                $image =
                    time() .
                    '_img_' .
                    basename($_FILES['image']['name']);

                move_uploaded_file(
                    $_FILES['image']['tmp_name'],
                    '../../assets/img/produits/' . $image
                );
            }
        }

        if (!empty($_FILES['image_banniere']['name'])) {

            if (
                in_array(
                    $_FILES['image_banniere']['type'],
                    $allowedTypes
                )
            ) {

                $image_banniere =
                    time() .
                    '_ban_' .
                    basename($_FILES['image_banniere']['name']);

                move_uploaded_file(
                    $_FILES['image_banniere']['tmp_name'],
                    '../../assets/img/produits/' . $image_banniere
                );
            }
        }

        $slug = strtolower(trim($_POST['nom']));
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        $slug = trim($slug, '-');

        $stmt = $pdo->prepare("
            UPDATE produits
            SET
                nom = :nom,
                slug = :slug,
                description = :description,
                image = :image,
                image_banniere = :image_banniere,
                id_category = :id_category,
                id_type = :id_type
            WHERE id_produit = :id
        ");

        $stmt->execute([
            'nom' => $_POST['nom'],
            'slug' => $slug,
            'description' => $_POST['description'],
            'image' => $image,
            'image_banniere' => $image_banniere,
            'id_category' => $_POST['id_category'],
            'id_type' => !empty($_POST['id_type'])
                ? $_POST['id_type']
                : null,
            'id' => $id
        ]);

        $stmtDelete = $pdo->prepare("
            DELETE FROM produit_format
            WHERE id_produit = :id
        ");

        $stmtDelete->execute([
            'id' => $id
        ]);

        if (!empty($_POST['formats'])) {

            $stmtInsert = $pdo->prepare("
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

                $stmtInsert->execute([
                    'id_produit' => $id,
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
    <title>Modifier produit</title>
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/log.css">
    </head>

    <body>
        <section>
            <form method="POST" enctype="multipart/form-data">
                <input type="text" name="nom" value="<?= htmlspecialchars($produit['nom']) ?>" required>

                <textarea name="description"><?= htmlspecialchars($produit['description']) ?></textarea>

                <p>Image actuelle :</p>
                <img src="../../assets/img/produits/<?= htmlspecialchars($produit['image']) ?>" width="150">
                <input type="file" name="image">
                
                <p>Bannière actuelle :</p>
                <img src="../../assets/img/produits/<?= htmlspecialchars($produit['image_banniere']) ?>" width="250">
                <input type="file" name="image_banniere">
                
                <select name="id_category">
                    <?php foreach ($categories as $categorie): ?>
                    
                    <option value="<?= $categorie['id_category'] ?>" <?= $categorie['id_category'] == $produit['id_category'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($categorie['nom']) ?>
                    </option>
                    
                    <?php endforeach; ?>
                </select>

                <select name="id_type">
                    <option value="">Aucun</option>
                    <?php foreach ($types as $type): ?>

                    <option value="<?= $type['id_type'] ?>" <?= $type['id_type'] == $produit['id_type'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($type['nom']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>

                <hr>

                <h3>Formats</h3>

                <?php foreach ($formats as $format): ?>
                <?php
                    $checked = isset($formatsProduit[$format['id_format']]);

                    $prix = $checked
                        ? $formatsProduit[$format['id_format']]['prix']
                        : '';

                    $stock = $checked
                        ? $formatsProduit[$format['id_format']]['stock']
                        : '';
                ?>
                <div style="margin-bottom:15px;">
                    <label>
                        <input
                        type="checkbox"
                        name="formats[]"
                        value="<?= $format['id_format'] ?>"
                        <?= $checked ? 'checked' : '' ?>
                        >
                        <?= htmlspecialchars($format['libelle']) ?>
                    </label>
                    <input
                    type="number"
                    step="0.01"
                    name="prix[<?= $format['id_format'] ?>]"
                    value="<?= $prix ?>"
                    placeholder="Prix"
                    >
                    <input
                    type="number"
                    name="stock[<?= $format['id_format'] ?>]"
                    value="<?= $stock ?>"
                    placeholder="Stock"
                    >
                </div>
                <?php endforeach; ?>
                <button type="submit">
                Mettre à jour
                </button>
            </form>
        </section>
    </body>
</html>