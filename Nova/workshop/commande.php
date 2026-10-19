<?php

require_once 'config/init.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: panier.php');
    exit();
}

if (empty($_SESSION['panier'])) {
    die('Panier vide');
}

$nom = trim($_POST['nom']);
$prenom = trim($_POST['prenom']);
$email = trim($_POST['email']);
$adresse = trim($_POST['adresse']);
$ville = trim($_POST['ville']);
$code_postal = trim($_POST['code_postal']);
$pays = trim($_POST['pays']);
$telephone = trim($_POST['telephone']);

$total = 0;

$detailsCommande = [];

foreach ($_SESSION['panier'] as $item) {

    $stmt = $pdo->prepare("
        SELECT
            id_produit_format,
            prix
        FROM produit_format
        WHERE id_produit = :id_produit
        AND id_format = :id_format
    ");

    $stmt->execute([
        'id_produit' => $item['id_produit'],
        'id_format' => $item['id_format']
    ]);

    $format = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$format) {
        continue;
    }

    $sousTotal = $format['prix'] * $item['quantite'];

    $total += $sousTotal;

    $detailsCommande[] = [
        'id_produit_format' => $format['id_produit_format'],
        'prix' => $format['prix'],
        'quantite' => $item['quantite']
    ];
}

$stmt = $pdo->prepare("
INSERT INTO commandes
(
    id_user,
    montant_total,
    nom_client,
    prenom_client,
    email_client,
    adresse,
    ville,
    code_postal,
    pays,
    telephone
)
VALUES
(
    :id_user,
    :montant_total,
    :nom_client,
    :prenom_client,
    :email_client,
    :adresse,
    :ville,
    :code_postal,
    :pays,
    :telephone
)
");

$stmt->execute([
    'id_user' => $_SESSION['user']['id_user'] ?? null,
    'montant_total' => $total,
    'nom_client' => $nom,
    'prenom_client' => $prenom,
    'email_client' => $email,
    'adresse' => $adresse,
    'ville' => $ville,
    'code_postal' => $code_postal,
    'pays' => $pays,
    'telephone' => $telephone
]);

$idCommande = $pdo->lastInsertId();

$stmtDetail = $pdo->prepare("
INSERT INTO detail_commande
(
    id_commande,
    id_produit_format,
    quantite,
    prix_unitaire
)
VALUES
(
    :id_commande,
    :id_produit_format,
    :quantite,
    :prix_unitaire
)
");

foreach ($detailsCommande as $detail) {

    $stmtDetail->execute([
        'id_commande' => $idCommande,
        'id_produit_format' => $detail['id_produit_format'],
        'quantite' => $detail['quantite'],
        'prix_unitaire' => $detail['prix']
    ]);
}

unset($_SESSION['panier']);

header('Location: achat.php?id=' . $idCommande);
exit();