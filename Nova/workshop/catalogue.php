<?php
require_once "includes/parts/header.php";
require_once "config/init.php";

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

$categoriesSelectionnees = $_GET['categories'] ?? [];
$typeSelectionne = $_GET['type'] ?? null;

$sql = "
SELECT
    p.id_produit,
    p.nom,
    p.description,
    p.image,
    p.slug,
    c.nom AS categorie,
    t.nom AS type,
    pf.prix,
    f.libelle AS format

FROM produits p

LEFT JOIN categories c
    ON p.id_category = c.id_category

LEFT JOIN types t
    ON p.id_type = t.id_type

LEFT JOIN produit_format pf
    ON pf.id_produit_format = (
        SELECT pf2.id_produit_format
        FROM produit_format pf2
        WHERE pf2.id_produit = p.id_produit
        ORDER BY pf2.prix ASC
        LIMIT 1
    )

LEFT JOIN formats f
    ON pf.id_format = f.id_format

WHERE 1=1
";

$params = [];

if (!empty($categoriesSelectionnees)) {

    $placeholders = [];

    foreach ($categoriesSelectionnees as $index => $categorie) {

        $placeholder = ":cat$index";

        $placeholders[] = $placeholder;

        $params[$placeholder] = $categorie;
    }

    $sql .= "
    AND c.nom IN (" . implode(',', $placeholders) . ")
    ";
}

if (!empty($typeSelectionne)) {

    $sql .= "
    AND t.nom = :type
    ";

    $params[':type'] = $typeSelectionne;
}

$sql .= "
GROUP BY p.id_produit
ORDER BY p.nom ASC
";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<body>
    <section>
        <div class="sidebar">
            <aside class="sidebar">
                <form method="GET">
                    <h2 class="catalogue">Catégories</h2>
                    <div class="filtre">
                        <?php foreach ($categories as $categorie): ?>
                            <label>
                                <input type="checkbox"name="categories[]"value="<?= htmlspecialchars($categorie['nom']) ?>"<?= in_array($categorie['nom'],$categoriesSelectionnees) ? 'checked' : '' ?>>
                                <?= htmlspecialchars($categorie['nom']) ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <h2 class="catalogue">Types</h2>
                    <div class="filtre">
                        <label>
                            <input type="radio"name="type"value=""<?= empty($typeSelectionne) ? 'checked' : '' ?>>
                            Tous
                        </label>
                        <?php foreach ($types as $type): ?>
                            <label>
                                <input type="radio"name="type"value="<?= htmlspecialchars($type['nom']) ?>"<?= $typeSelectionne === $type['nom']? 'checked': '' ?>>
                                <?= htmlspecialchars($type['nom']) ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <br>
                    <button type="submit">
                        Filtrer
                    </button>
                </form>
            </aside>
            <main class="main-content">
                <h1 class="catalogue">Catalogue</h1>
                <p>
                    <?= count($produits) ?> produit(s)
                </p>
                <div class="bloc-catalogue">
                    <?php foreach ($produits as $produit): ?>
                        <article class="hover-produit">
                            <a class="produit"href="produit.php?id=<?= $produit['id_produit'] ?>">
                                <img class="produit"src="assets/img/produits/<?= htmlspecialchars($produit['image']) ?>"alt="<?= htmlspecialchars($produit['nom']) ?>">
                                <h3>
                                    <?= htmlspecialchars($produit['nom']) ?>
                                </h3>
                                <p class="petit">
                                    <?= htmlspecialchars($produit['description']) ?>
                                </p>
                                <p class="moyen">
                                    <?= htmlspecialchars($produit['format']) ?>
                                </p>
                                <p class="prix">
                                    À partir de
                                    <?= number_format($produit['prix'], 2, ',', ' ') ?>
                                    €
                                </p>
                            </a>
                        </article>
                    <?php endforeach; ?>
                </div>
            </main>
        </div>
    </section>
</body>

<?php require_once "includes/parts/footer.php"; ?>