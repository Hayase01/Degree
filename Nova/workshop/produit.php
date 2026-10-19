<?php
    require_once "includes/parts/header.php";
    require_once "config/init.php";
    
    $id = $_GET['id'] ?? null;
    
    if (!$id || !is_numeric($id)) {
        die("Produit invalide");
    }
    
    $stmt = $pdo->prepare("
    SELECT
        p.*,
        c.nom AS categorie,
        t.nom AS type
    
    FROM produits p
    
    LEFT JOIN categories c
        ON p.id_category = c.id_category
    
    LEFT JOIN types t
        ON p.id_type = t.id_type
    
    WHERE p.id_produit = :id
    ");
    
    $stmt->execute([
        'id' => $id
    ]);
    
    $produit = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$produit) {
        die("Produit introuvable");
    }
    
    $stmtFormats = $pdo->prepare("
    SELECT
        pf.*,
        f.libelle
    
    FROM produit_format pf
    
    INNER JOIN formats f
        ON pf.id_format = f.id_format
    
    WHERE pf.id_produit = :id
    
    ORDER BY pf.prix ASC
    ");
    
    $stmtFormats->execute([
        'id' => $id
    ]);
    
    $formats = $stmtFormats->fetchAll(PDO::FETCH_ASSOC);
    
    $stmtAssocies = $pdo->prepare("
    SELECT
        p.id_produit,
        p.nom,
        p.image,
        MIN(pf.prix) AS prix
    
    FROM produits p
    
    LEFT JOIN produit_format pf
        ON p.id_produit = pf.id_produit
    
    WHERE p.id_category = :categorie
    AND p.id_produit != :id
    
    GROUP BY p.id_produit
    
    LIMIT 3
    ");
    
    $stmtAssocies->execute([
        'categorie' => $produit['id_category'],
        'id' => $id
    ]);
    
    $associes = $stmtAssocies->fetchAll(PDO::FETCH_ASSOC);
?>

<body>
    <section>
        <div class="wrapper">
            <img class="produit-hero"src="assets/img/produits/<?= htmlspecialchars($produit['image_banniere']) ?>"alt="<?= htmlspecialchars($produit['nom']) ?>">
            <article class="presentation">
                <img class="unique"src="assets/img/produits/<?= htmlspecialchars($produit['image']) ?>"alt="<?= htmlspecialchars($produit['nom']) ?>">
                <div class="presentation">
                    <h3>
                        <?= htmlspecialchars($produit['nom']) ?>
                    </h3>
                    <?php if (!empty($formats)): ?>
                        <p class="prix">
                            À partir de
                            <?= number_format($formats[0]['prix'], 2, ',', ' ') ?>
                            €
                        </p>
                    <?php endif; ?>
                    <p class="petit">
                        <?= htmlspecialchars($produit['description']) ?>
                    </p>
                    <br>
                    <form class="panier" action="ajout_panier.php" method="POST">
                        <input type="hidden"name="id_produit"value="<?= $produit['id_produit'] ?>">
                        <?php foreach ($formats as $index => $format): ?>
                            <label class="panier">
                                <input type="radio"name="id_format"value="<?= $format['id_format'] ?>"<?= $index === 0 ? 'checked' : '' ?>>
                                <?= htmlspecialchars($format['libelle']) ?>
                                -
                                <?= number_format($format['prix'], 2, ',', ' ') ?> €
                            </label>
                        <?php endforeach; ?>
                        <button type="submit">
                            Ajouter au panier
                        </button>
                    </form>
                </div>
            </article>
        </div>
        </section>
        <section>
        <div class="wrapper">
            <h2>Produits associés</h2>
            <div class="bloc-produits">
                <?php foreach ($associes as $associe): ?>
                    <article class="hover-produit">
                        <a class="produit"href="produit.php?id=<?= $associe['id_produit'] ?>">
                            <img class="produit"src="assets/img/produits/<?= htmlspecialchars($associe['image']) ?>"alt="<?= htmlspecialchars($associe['nom']) ?>">
                            <h3>
                                <?= htmlspecialchars($associe['nom']) ?>
                            </h3>
                            <p class="prix">
                                <?= number_format($associe['prix'], 2, ',', ' ') ?>
                                €
                            </p>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php require_once "includes/parts/footer.php"; ?>
</body>
</html>