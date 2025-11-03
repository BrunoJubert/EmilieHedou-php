<?php
session_start();
include_once __DIR__ . '/../../includes/db.php';

// 1. Mettre la locale en français pour Windows et Mac
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    setlocale(LC_TIME, 'fra_fra'); // Windows
} else {
    setlocale(LC_TIME, 'fr_FR.UTF-8'); // Mac/Linux
}

// 2. Récupération des concerts
$concerts = [];
$sql = "SELECT * FROM concerts ORDER BY date ASC";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $concerts[] = $row;
    }
}

$showLoginModal = false;
if (isset($_GET['login'])) {
    $showLoginModal = true;
}

$page = 'concerts';
include_once __DIR__ . '/../partials/header.php';
?>

<!-- Concerts Header -->
<div class="concert-header">    
   <h1>Concerts</h1>
   <p>Retrouvez ici les prochaines dates de concerts d'Emilie Hedou. Des concerts gratuits et aussi dans des salles prestigieuses.</p>
</div>

<section id="concerts" class="hero concert-hero">
    <div class="concert-list">
        <?php if (empty($concerts)) : ?>
            <p>Aucun concert à venir pour le moment.</p>
        <?php else : ?>
            <div class="concert-cards-grid">
                <?php foreach ($concerts as $concert) : ?>
                    <div class="concert-card">
                        <div class="concert-card-content">
                            <div class="concert-card-main">
                                <h3 class="concert-artist"><?= htmlspecialchars($concert['artist']) ?></h3>
                                <?php if (!empty($concert['description'])) : ?>
                                    <p class="concert-description"><?= htmlspecialchars($concert['description']) ?></p>
                                <?php endif; ?>
                                <div class="concert-info">
                                    <span class="concert-venue"><?= htmlspecialchars($concert['venue']) ?></span>
                                    <?php
                                    $jours = ['dimanche','lundi','mardi','mercredi','jeudi','vendredi','samedi'];
                                    $mois = ['janvier','février','mars','avril','mai','juin','juillet','août','septembre','octobre','novembre','décembre'];

                                    $date = new DateTime($concert['date']);
                                    $jour = $jours[$date->format('w')];
                                    $moisNom = $mois[$date->format('n') - 1];
                                    $jourNum = $date->format('d');
                                    $annee = $date->format('Y');
                                    ?>
                                    <span class="concert-date">
                                        <?= "$jour $jourNum $moisNom $annee" ?>
                                    </span>

                                    <?php if (!empty($concert['time'])) : ?>
                                        <span class="concert-time">
                                            à <?= substr($concert['time'], 0, 5) ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <?php if (!empty($concert['price']) && $concert['price'] > 0) : ?>
                                    <p class="concert-price"><strong>Prix :</strong> <?= number_format($concert['price'], 2) ?> €</p>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($concert['phone'])) : ?>
                            <div class="concert-phone">
                                <span class="phone-number"><?= htmlspecialchars($concert['phone']) ?></span>
                                <a href="tel:<?= htmlspecialchars($concert['phone']) ?>" class="btn-call" title="Appeler pour réserver">
                                    <i class="fas fa-phone"></i>Téléphoner
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include_once __DIR__ . '/../partials/footer.php'; ?>
