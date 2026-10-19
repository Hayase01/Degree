<?php
    require_once "includes/parts/miniheader.php";
    require_once "config/init.php";

    $id = $_GET['id'] ?? 0;

    $stmt = $pdo->prepare("
    SELECT *
    FROM commandes
    WHERE id_commande = :id
    ");

    $stmt->execute([
        'id' => $id
    ]);

    $commande = $stmt->fetch();

    if (!$commande) {
        die("Commande introuvable");
    }
?>

    <body>
        <section class="wrapper">
            <div class="log">
                <h1 class="log2">Merci pour votre commande, un reçu vous sera envoyer par mail.</h1>
                <p class="log">
                    Commande n°
                    <?= $commande['id_commande'] ?>
                </p>
                <p class="log">
                    Montant total :
                    <?= number_format($commande['montant_total'], 2, ',', ' ') ?>
                    €
                </p>
                <p class="log">
                    Statut :
                    <?= htmlspecialchars($commande['statut']) ?>
                </p>
                <a class="panier "href="index.php">
                    Retour à l'accueil
                </a>
            </div>
        </section>
    </body>
<?php require_once "includes/parts/minifooter.php"; ?>
