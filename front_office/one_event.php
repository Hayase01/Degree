<?php
    require_once __DIR__ . '/../includes/header.php';
    require_once __DIR__ . '/../includes/init.php';

    $id = $_GET['id'] ?? null;

    $stmt = $pdo->prepare("
        SELECT events.*, categories.nom AS categorie
        FROM events
        JOIN categories ON events.category_id = categories.id
        WHERE events.id = :id
    ");

    $stmt->execute(['id' => $id]);

    $event = $stmt->fetch();
    
    if (!$event) {
    echo  '<div class="error" style="font-size: 10rem;">ÉVENEMENT INEXISTANT</div>';
    exit;
    }
?>

    <section>
        <div>
            <img class="event" src="../assets/images/events/<?= $event['image'] ?>" alt="event">
        </div>
    </section>

    <section>
        <div class="utile">
            <ul>
                <li><h3><?= $event['titre'] ?></h3></li>
                <li>Date:  <?= date('d-m-Y', strtotime($event['date'])) ?> à <?= $event['heure'] ?></li>
                <li>Adresse:  <?= $event['adresse'] ?></li>
                <li>Catégorie:  <?= $event['categorie'] ?></li>
                <li>Prix:  <?= $event['prix'] ?>€</li>
                <li>Description:  <?= $event['description'] ?></li>
                <li>Organisateur:  <?= $event['organisateur_nom'] ?></li>
                <li>Nombre de place disponible:  <?= $event['place_dispo'] ?></li>
            </ul>
    </section>
    
    <section>
        <div class=button>
            <a class="button1" href="events.php">Retour vers tous les évenements</a>
        </div>
    </section>
<?php
    require_once __DIR__ . '/../includes/footer.php';
?>