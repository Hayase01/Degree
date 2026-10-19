<?php
    require_once __DIR__ . '/../includes/header.php';
    require_once '../includes/init.php';

    $stmt = $pdo->query("SELECT id, nom FROM categories ORDER BY nom ASC");    
    $categories = $stmt->fetchAll();

    $page = max(1, (int)($_GET['page'] ?? 1));
    $limit = 12;
    $offset = ($page - 1) * $limit;
    
    $category = $_GET['category'] ?? 'all';
    $period = $_GET['period'] ?? 'all';

    $where = [];
    $params = [];
    
    if ($category !== 'all') {
        $where[] = "events.category_id = :category";
        $params['category'] = $category;
    }

    if ($period === 'week') {
        $where[] = "date >= CURDATE() AND date <= DATE_ADD(CURDATE(), INTERVAL 7 DAY)";
    } elseif ($period === 'month') {
        $where[] = "date >= CURDATE() AND date <= DATE_ADD(CURDATE(), INTERVAL 1 MONTH)";
    }else {
            $where[] = "date >= CURDATE()";
    }

    $whereSQL = "";

    if (!empty($where)) {
        $whereSQL = "WHERE " . implode(" AND ", $where);
    }

    $stmt = $pdo->prepare("
        SELECT events.*, categories.nom AS categorie
        FROM events
        JOIN categories ON events.category_id = categories.id
        $whereSQL
        ORDER BY date ASC
        LIMIT $limit OFFSET $offset
    ");

    $stmt->execute($params);
    $events = $stmt->fetchAll();
    
    $stmt = $pdo->prepare("
    SELECT COUNT(*) 
    FROM events
    $whereSQL
    ");

    $stmt->execute($params);
    $total = $stmt->fetchColumn();

    $totalPages = ceil($total / $limit);
    
?>

<section>
    <form method="GET" class="filters">
        <select name="category" onchange="this.form.submit()">
            <option value="all">Toutes les catégories</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>"
                    <?= $category == $cat['id'] ? 'selected' : '' ?>>
                    <?= $cat['nom'] ?>
                </option>
            <?php endforeach; ?>
        </select>
        <select name="period" onchange="this.form.submit()">
            <option value="all" <?= $period == 'all' ? 'selected' : '' ?>>Toutes</option>
            <option value="week" <?= $period == 'week' ? 'selected' : '' ?>>Cette semaine</option>
            <option value="month" <?= $period == 'month' ? 'selected' : '' ?>>Ce mois</option>
        </select>

    </form>
</section>

<section>
    <div class="wrapper">
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
        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?category=<?= $category ?>&period=<?= $period ?>&page=<?= $i ?>"class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>
        </div>
    </div>
</section>

<?php
    require_once __DIR__ . '/../includes/footer.php';
?>
