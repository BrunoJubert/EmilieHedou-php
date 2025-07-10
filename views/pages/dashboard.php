<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: /login');
    exit;
}

// Connexion à la base de données
include_once __DIR__ . '/../../includes/db.php';

// Gestion de l'ajout d'un concert
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['artist']) && empty($_POST['edit_id']) && empty($_POST['delete_id'])) {
    $artist = $_POST['artist'];
    $image_url = $_POST['image_url'] ?? '';
    $venue = $_POST['venue'];
    $date = $_POST['date'];
    $time = $_POST['time'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $price = $_POST['price'] ?? 0;
    $description = $_POST['description'] ?? '';

    $stmt = $conn->prepare("INSERT INTO concerts (artist, image_url, venue, date, time, phone, price, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssds", $artist, $image_url, $venue, $date, $time, $phone, $price, $description);
    $stmt->execute();
    $stmt->close();

    // Pour éviter le renvoi du formulaire en cas de refresh
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

// Gestion de la modification d'un concert
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {
    $edit_id = intval($_POST['edit_id']);
    $artist = $_POST['artist'];
    $image_url = $_POST['image_url'] ?? '';
    $venue = $_POST['venue'];
    $date = $_POST['date'];
    $time = $_POST['time'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $price = $_POST['price'] ?? 0;
    $description = $_POST['description'] ?? '';

    $stmt = $conn->prepare("UPDATE concerts SET artist=?, image_url=?, venue=?, date=?, time=?, phone=?, price=?, description=? WHERE id=?");
    $stmt->bind_param("ssssssdsi", $artist, $image_url, $venue, $date, $time, $phone, $price, $description, $edit_id);
    $stmt->execute();
    $stmt->close();

    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

// Gestion de la suppression d'un concert
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);
    $conn->query("DELETE FROM concerts WHERE id = $delete_id");
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit();
}

// Récupération des concerts
$concerts = [];
$sql = "SELECT * FROM concerts ORDER BY date ASC";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $concerts[] = $row;
    }
}
?>

<?php include_once __DIR__ . '/../partials/header.php'; ?>

<div class="admin-dashboard">
    <h1>Bienvenue <?= htmlspecialchars($_SESSION['user']['firstname']) ?> </h1>
    <p>Ceci est une page protégée.</p>
    <a href="/logout" class="logout-btn">Se déconnecter</a>
</div>

<!-- Bouton pour afficher/masquer tout le bloc concerts -->
<button type="button" class="dashboard-toggle" onclick="toggleConcertsSection()" id="concerts-toggle-btn"
    aria-expanded="false">
    Gestion des Concerts
    <span class="toggle-arrow" id="concerts-arrow">&#9654;</span>
</button>

<!-- Bloc caché par défaut -->
<div id="concerts-section" style="display: none;">
    <div class="add-concert-form">
        <h2>Ajouter un nouveau concert</h2>
        <form class="concert-form" action="" method="POST">
            <div class="form-group">
                <label for="artist">Nom de l'artiste</label>
                <input type="text" id="artist" name="artist" placeholder="Nom de l'artiste" required>
            </div>
            <div class="form-group">
                <label for="image_url">Lien de l'image (URL)</label>
                <input type="url" id="image_url" name="image_url" placeholder="https://...">
                <small>Copie-colle l’URL d’une image ou d’une affiche (optionnel).</small>
            </div>
            <div class="form-group">
                <label for="venue">Lieu</label>
                <input type="text" id="venue" name="venue" placeholder="Lieu" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" id="date" name="date" required>
                </div>
                <div class="form-group">
                    <label for="time">Heure</label>
                    <input type="time" id="time" name="time">
                </div>
            </div>
            <div class="form-group">
                <label for="phone">Téléphone pour réserver (facultatif)</label>
                <input type="tel" id="phone" name="phone" placeholder="06 12 34 56 78">
            </div>
            <div class="form-group">
                <label for="price">Prix (€)</label>
                <input type="number" id="price" name="price" step="0.01" min="0" placeholder="Prix">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="3" placeholder="Description"></textarea>
            </div>
            <button type="submit" class="btn-primary">Ajouter le concert</button>
        </form>
    </div>
</div>


    <div class="concerts-admin-list">
        <h2>Aperçu des concerts</h2>
        <?php if (empty($concerts)) : ?>
            <p>Aucun concert enregistré pour l’instant.</p>
        <?php else : ?>
            <div class="concerts-admin-cards">
                <?php foreach ($concerts as $concert) : ?>
                    <div class="concert-admin-card">
                        <div class="concert-card-header">
                            <span class="concert-date">
                                <?= date('d/m/Y', strtotime($concert['date'])) ?>
                                <?php if (!empty($concert['time'])) : ?>
                                    à <?= substr($concert['time'], 0, 5) ?>
                                <?php endif; ?>
                            </span>
                            <span class="concert-venue">
                                <?= htmlspecialchars($concert['venue']) ?>
                            </span>
                        </div>
                        <div class="concert-admin-info">
                            <h3 class="concert-artist">
                                <?= htmlspecialchars($concert['artist']) ?>
                            </h3>
                            <?php if (!empty($concert['description'])) : ?>
                                <p class="concert-description">
                                    <?= htmlspecialchars($concert['description']) ?>
                                </p>
                            <?php endif; ?>
                            <div class="concert-admin-actions">
                                <!-- Supprimer -->
                                <form action="" method="POST" style="display:inline;">
                                    <input type="hidden" name="delete_id" value="<?= $concert['id'] ?>">
                                    <button type="submit" class="btn-delete" onclick="return confirm('Supprimer ce concert ?')">Supprimer</button>
                                </form>
                                <!-- Modifier -->
                                <button type="button"
                                        class="btn-edit"
                                        onclick="showEditConcertForm(<?= $concert['id'] ?>)">
                                    Modifier
                                </button>
                            </div>
                            <!-- Formulaire d'édition inline (caché par défaut) -->
                            <div id="edit-concert-form-<?= $concert['id'] ?>" class="edit-concert-form" style="display:none; margin-top:10px;">
                                <form action="" method="POST">
                                    <input type="hidden" name="edit_id" value="<?= $concert['id'] ?>">
                                    <div class="form-group">
                                        <label>Nom de l'artiste</label>
                                        <input type="text" name="artist" value="<?= htmlspecialchars($concert['artist']) ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Lien de l'image (URL)</label>
                                        <input type="url" name="image_url" value="<?= htmlspecialchars($concert['image_url']) ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Lieu</label>
                                        <input type="text" name="venue" value="<?= htmlspecialchars($concert['venue']) ?>" required>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label>Date</label>
                                            <input type="date" name="date" value="<?= htmlspecialchars($concert['date']) ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Heure</label>
                                            <input type="time" name="time" value="<?= htmlspecialchars($concert['time']) ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Téléphone</label>
                                        <input type="tel" name="phone" value="<?= htmlspecialchars($concert['phone']) ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Prix (€)</label>
                                        <input type="number" name="price" value="<?= htmlspecialchars($concert['price']) ?>" step="0.01" min="0">
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea name="description" rows="3"><?= htmlspecialchars($concert['description']) ?></textarea>
                                    </div>
                                    <div class="edit-btn-row">
                                        <button type="submit" class="btn-primary-edit">Valider</button>
                                        <button type="button" class="btn-cancel" onclick="hideEditConcertForm(<?= $concert['id'] ?>)">Annuler</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include_once __DIR__ . '/../partials/footer.php'; ?>

<!-- JS pour afficher/masquer le bloc concerts et les formulaires d'édition -->
<script>
function toggleConcertsSection() {
    const section = document.getElementById('concerts-section');
    const btn = document.getElementById('concerts-toggle-btn');
    const arrow = document.getElementById('concerts-arrow');
    if (section.style.display === 'none') {
        section.style.display = 'block';
        btn.setAttribute('aria-expanded', 'true');
        arrow.innerHTML = '▼';
    } else {
        section.style.display = 'none';
        btn.setAttribute('aria-expanded', 'false');
        arrow.innerHTML = '►';
    }
}

function showEditConcertForm(id) {
    document.getElementById('edit-concert-form-' + id).style.display = 'block';
}
function hideEditConcertForm(id) {
    document.getElementById('edit-concert-form-' + id).style.display = 'none';
}
</script>