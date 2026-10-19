<?php
    require_once __DIR__ . '/../includes/header.php';
    require_once '../includes/init.php';

    $stmt = $pdo->query("
        SELECT events.*, categories.nom AS categorie
        FROM events
        JOIN categories ON events.category_id = categories.id
        WHERE events.Date >= CURDATE()
        ORDER BY events.Date ASC
        LIMIT 6
    ");

    $events = $stmt->fetchAll();
?>

    <section>
        <div class="intro">
            <h1>BXL Events</h1>
            <p>
                Bienvenue sur BXL Events, votre plateforme dédiée à la découverte des événements incontournables à Bruxelles. 
                Ce projet a été réalisé dans le cadre de mon cours d’ADB, avec pour objectif de concevoir une application complète, de la base de données jusqu’à l’interface utilisateur. 
                Vous y trouverez une sélection d’événements variés, régulièrement mise à jour. 
                Grâce à une gestion dynamique via un back-office, les contenus peuvent être facilement ajoutés et modifiés. 
                Bonne découverte et profitez pleinement de la vie culturelle bruxelloise ! 🎉
            </p>
        </div>
    </section>

    <section>
        <div class="wrapper">
            <h2>Événements à venir</h2>
            <div class="bloc-events">
                <?php foreach ($events as $event): ?>
                <article>
                    <img class="events" src="..\assets\images\events\<?= $event['image'] ?>" alt="event">
                    <h3><?= $event['titre'] ?></h3>
                    <p><?= date('d-m-Y', strtotime($event['date'])) ?> à <?= $event['heure'] ?></p>
                    <p><?= $event['adresse'] ?></p>
                    <p><?= $event['categorie'] ?></p>
                    <p><?= $event['prix'] ?>€</p>
                    <a class="button2" href="one_event.php?id=<?= $event['id'] ?>">Voir détails</a>
                </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section>
        <div class=button>
            <a class="button1" href="events.php">Vers le catalogue</a>
        </div>
    </section>

<?php
    require_once __DIR__ . '/../includes/footer.php';
?>