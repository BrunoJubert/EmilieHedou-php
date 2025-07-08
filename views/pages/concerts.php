<?php
// 1. Connexion à la base de données
include_once __DIR__ . '/../../includes/db.php';

// 2. Récupération des concerts
$concerts = [];
$sql = "SELECT * FROM concerts ORDER BY date ASC";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $concerts[] = $row;
    }
}
?>

<?php
$showLoginModal = false;
if (isset($_GET['login'])) {
    $showLoginModal = true;
}
?>


<?php include_once __DIR__ . '/../partials/header.php'; ?>

<section id="concerts" class="hero section-appear">
    <h1>Concerts</h1>
    <p>Retrouvez ici les prochaines dates de concerts d'Emilie Hedou.</p>
    <div class="concert-list">
        <?php if (empty($concerts)) : ?>
            <p>Aucun concert à venir pour le moment.</p>
        <?php else : ?>
            <div class="concert-cards-grid">
                <?php foreach ($concerts as $concert) : ?>
                    <div class="concert-card">
                        <?php if (!empty($concert['image_url'])) : ?>
                            <div class="concert-card-img-wrapper">
                                <img src="<?= htmlspecialchars($concert['image_url']) ?>" alt="Affiche du concert" class="concert-img">
                            </div>
                        <?php endif; ?>
                        <div class="concert-card-content">
                            <div class="concert-info">
                                <span class="concert-venue"><?= htmlspecialchars($concert['venue']) ?></span>
                                <span class="concert-date">
                                    <?= date('d/m/Y', strtotime($concert['date'])) ?>
                                </span>
                                <?php if (!empty($concert['time'])) : ?>
                                    <span class="concert-time">
                                        à <?= substr($concert['time'], 0, 5) ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <h3 class="concert-artist"><?= htmlspecialchars($concert['artist']) ?></h3>
                            <?php if (!empty($concert['description'])) : ?>
                                <p class="concert-description"><?= htmlspecialchars($concert['description']) ?></p>
                            <?php endif; ?>
                            <?php if (!empty($concert['price']) && $concert['price'] > 0) : ?>
                                <p class="concert-price"><strong>Prix :</strong> <?= number_format($concert['price'], 2) ?> €</p>
                            <?php endif; ?>
                            <?php if (!empty($concert['phone'])) : ?>
                                <p class="concert-phone"><strong>Réservation :</strong> <a href="tel:<?= htmlspecialchars($concert['phone']) ?>"><?= htmlspecialchars($concert['phone']) ?></a></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include_once __DIR__ . '/../partials/footer.php'; ?>
