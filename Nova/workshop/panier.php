<?php  
    require_once "includes/parts/miniheader.php";
    require_once "config/init.php";

    $panier = $_SESSION['panier'] ?? [];

    $articles = [];
    $total = 0;

    foreach ($panier as $cle => $item) {
        $stmt = $pdo->prepare("
        SELECT
            p.nom,
            p.image,
            f.libelle,
            pf.prix,
            pf.id_produit_format

        FROM produit_format pf

        INNER JOIN produits p
            ON pf.id_produit = p.id_produit

        INNER JOIN formats f
            ON pf.id_format = f.id_format

        WHERE pf.id_produit = :id_produit
        AND pf.id_format = :id_format
        ");

        $stmt->execute([
            'id_produit' => $item['id_produit'],
            'id_format' => $item['id_format']
        ]);

        $produit = $stmt->fetch();

        if ($produit) {

            $produit['quantite'] = $item['quantite'];
            $produit['cle'] = $cle;

            $produit['sous_total'] =
                $produit['prix']
                * $item['quantite'];

            $total += $produit['sous_total'];

            $articles[] = $produit;
        }
    }
?>
    <body>
        <section class="checkout">
            <div class="cart-summary">
                <h2>Résumé de la commande</h2>
                <?php foreach ($articles as $article): ?>
                <article class="cart-item">
                    <img src="assets/img/produits/<?= htmlspecialchars($article['image']) ?>"alt="">
                    <div class="cart-info">
                        <h3>
                            <?= htmlspecialchars($article['nom']) ?>
                        </h3>
                        <p>
                            <?= htmlspecialchars($article['libelle']) ?>
                        </p>
                    </div>
                    <div class="cart-quantity">
                        <a href="panier_action.php?action=moins&cle=<?= urlencode($article['cle']) ?>">
                            -
                        </a>
                        <span>
                            <?= $article['quantite'] ?>
                        </span>
                        <a href="panier_action.php?action=plus&cle=<?= urlencode($article['cle']) ?>">
                            +
                        </a>
                    </div>
                    <p class="price">
                        <?= number_format(
                            $article['sous_total'],
                            2,
                            ',',
                            ' '
                        ) ?>
                        €
                    </p>
                    <a href="panier_action.php?action=delete&cle=<?= urlencode($article['cle']) ?>">
                        Supprimer
                    </a>
                </article>
                <?php endforeach; ?>
                <div class="cart-total">
                    <p>
                        Total :
                        <?= number_format($total, 2, ',', ' ') ?>
                        €
                    </p>
                </div>
            </div>

            <div class="checkout-form">
                <form class="log" action="commande.php" method="POST">
                    <h2>Contact</h2>
                    <input class="log" type="email" name="email" placeholder="Adresse e-mail" required>
                    <input class="log" type="text" name="prenom" placeholder="Prénom" required>
                    <input class="log" type="text" name="nom" placeholder="Nom" required>
                    <input class="log" type="text" name="adresse" placeholder="Adresse" required>
                    <input class="log" type="text" name="code_postal" placeholder="Code postal" required>
                    <input class="log" type="text" name="ville" placeholder="Ville" required>
                    <input class="log" type="text" name="telephone" placeholder="Téléphone">
                    <select class="log" name="pays">
                        <option value="Belgique">Belgique</option>
                        <option value="France">France</option>
                        <option value="Luxembourg">Luxembourg</option>
                    </select>

                    <button type="submit">
                        Finaliser la commande
                    </button>
                </form>
            </div>
        </section>
<?php
    require_once "includes/parts/minifooter.php"
?>