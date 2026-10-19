<?php
require_once '../config/admin_init.php';
requireLogin();

$id = $_GET['id'] ?? null;

if (!$id || !is_numeric($id)) {
    die("Commande invalide");
}

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $pdo->prepare("
        UPDATE commandes
        SET statut = :statut
        WHERE id_commande = :id
    ");

    $stmt->execute([
        'statut' => $_POST['statut'],
        'id' => $id
    ]);

    header('Location: commandes.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Modifier commande</title>

    <link rel="stylesheet" href="../assets/css/reset.css">
    <link rel="stylesheet" href="../assets/css/log.css">
</head>

<body>
    <section>
        <form method="POST">
            <h2>
                Commande #<?= $commande['id_commande'] ?>
            </h2>
        
            <p>
                <?= htmlspecialchars($commande['prenom_client']) ?>
                <?= htmlspecialchars($commande['nom_client']) ?>
            </p>
        
            <select name="statut">
                <option value="En attente" <?= $commande['statut'] === 'En attente' ? 'selected' : '' ?>>
                    En attente
                </option>
        
                <option value="Payee" <?= $commande['statut'] === 'Payee' ? 'selected' : '' ?>>
                    Payée
                </option>
        
                <option value="Expediee" <?= $commande['statut'] === 'Expediee' ? 'selected' : '' ?>>
                    Expédiée
                </option>
        
                <option value="Livree" <?= $commande['statut'] === 'Livree' ? 'selected' : '' ?>>
                    Livrée
                </option>
            </select>
            <button type="submit">
                Mettre à jour
            </button>
        </form>
    </section>
</body>
</html>