<?php
    require_once "includes/parts/header.php";
    require_once 'config/init.php';

    $stmt = $pdo->query("
    SELECT
        p.id_produit,
        p.nom,
        p.description,
        p.image,
        p.image_banniere,
        p.slug,
        c.nom AS categorie,
        t.nom AS type,
        MIN(pf.prix) AS prix,
        MIN(f.libelle) AS format
    
    FROM produits p
    
    INNER JOIN categories c
        ON p.id_category = c.id_category
    
    LEFT JOIN types t
        ON p.id_type = t.id_type
    
    LEFT JOIN produit_format pf
        ON p.id_produit = pf.id_produit
    
    LEFT JOIN formats f
        ON pf.id_format = f.id_format
    
    WHERE c.nom = 'Produit'
    
    GROUP BY p.id_produit
    ");

    $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $stmt = $pdo->query("
    SELECT
        p.id_produit,
        p.nom,
        p.description,
        p.image,
        p.slug,
        MIN(pf.prix) AS prix,
        MIN(f.libelle) AS format

    FROM produits p

    INNER JOIN categories c
        ON p.id_category = c.id_category

    LEFT JOIN produit_format pf
        ON p.id_produit = pf.id_produit

    LEFT JOIN formats f
        ON pf.id_format = f.id_format

    WHERE c.nom = 'Shaker'

    GROUP BY p.id_produit
");

$shakers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<body>
    <section>
        <div id="slider" class="carousel-container">
            <div class="carousel-track">
                <div class="slide">
                    <a href="produit.php?id=1">
                        <img src="assets/img/banniere/Null.Star 1.png" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="produit.php?id=2">
                        <img src="assets/img/banniere/banner accueil/molecular-prime-banner.png" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="produit.php?id=3">
                        <img src="assets/img/banniere/banner accueil/antimatter-drop-banner.png" alt="">
                    </a>
                </div>
                <div class="slide">
                    <a href="produit.php?id=4">
                        <img src="assets/img/banniere/banner accueil/wormhole-banner.png" alt="">
                    </a>
                </div>
            </div>
            <button id="precedent">&#10094;</button>
            <button id="suivant">&#10095;</button>
        </div>
    </section>

    <section>
        <div class="wrapper">
            <h2>En vedette</h2>
            <div class="bloc-produits">
                <?php foreach ($produits as $produit): ?>
                    <article class="hover-produit">
                        <a class="produit" href="produit.php?id=<?= $produit['id_produit'] ?>">
                            <img class="produit" src="assets/img/produits/<?= htmlspecialchars($produit['image']) ?>" alt="<?= htmlspecialchars($produit['nom']) ?>">
                            <h3><?= htmlspecialchars($produit['nom']) ?></h3>
                            <p class="petit">
                                <?= htmlspecialchars($produit['description']) ?>
                            </p>
                            <p class="moyen">
                                <?= htmlspecialchars($produit['format']) ?>
                            </p>
                            <p class="prix">
                                À partir de <?= htmlspecialchars($produit['prix']) ?> €
                            </p>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
            <div>
                <a class="catalogue" href="catalogue.php">
                    Tous nos produits
                </a>
            </div>
        </div>
    </section>

    <section>
        <div class="shaker-banner">
            <a href="cup.php"><img class="carousel-slider" src="assets/img/cups/7189037a-4534-42bd-a1b3-7f87c1789ed8.png" alt="shaker-perso"></a>
            <a href="cup.php"><h2><img src="assets/img/svg/cursor-hand.svg" alt="click"> Personnaliser votre shaker</h2></a>
        </div>
    </section>

    <section>
        <div class="wrapper">
            <h2>Nos shakers</h2>
            <div class="bloc-produits">
                <?php foreach ($shakers as $shaker): ?>
                    <article class="hover-produit">
                        <a class="produit"
                           href="produit.php?id=<?= $shaker['id_produit'] ?>">
                            <img
                                class="produit"
                                src="assets/img/produits/<?= htmlspecialchars($shaker['image']) ?>"
                                alt="<?= htmlspecialchars($shaker['nom']) ?>"
                            >
                            <h3>
                                <?= htmlspecialchars($shaker['nom']) ?>
                            </h3>
                            <p class="petit">
                                <?= htmlspecialchars($shaker['description']) ?>
                            </p>
                            <p class="moyen">
                                <?= htmlspecialchars($shaker['format']) ?>
                            </p>
                            <p class="prix">
                                À partir de
                                <?= number_format($shaker['prix'], 2, ',', ' ') ?>
                                €
                            </p>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php
        require_once "includes/parts/footer.php"
    ?>

</body>
</html>