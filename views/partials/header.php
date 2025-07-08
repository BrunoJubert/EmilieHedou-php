<?php
// Toujours démarrer la session AVANT tout HTML
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Emilie Hedou, Chanteuse Soul & Blues</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <script src="/EmilieHedou-php/public/js/coockieManager.js"></script>
    <link rel="stylesheet" href="/EmilieHedou-php/public/styles/styles.css" />
</head>

<body>
    <header class="musician-header sidebar-closed" id="sidebar">
        <nav class="navbar">
            <div class="sidebar-header">
                <div class="logo">
                    <span class="logo-main">Emilie</span>
                    <span class="logo-sub">HEDOU</span>
                </div>
                <button class="sidebar-toggle" id="sidebarToggle" aria-label="Réduire/ouvrir le menu">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
            <ul class="nav-links" id="navLinks">
            <?php if (!empty($_SESSION['user']['id'])): ?>
                <li>
                    <a href="/EmilieHedou-php/dashboard">
                        <i class="fas fa-gauge"></i>
                        <span class="nav-label">Dashboard</span>
                    </a>
                </li>
                <?php endif; ?>
                <li>
                    <a href="/EmilieHedou-php/">
                        <i class="fas fa-home"></i>
                        <span class="nav-label">Accueil</span>
                    </a>
                </li>
                <li>
                    <a href="/EmilieHedou-php/#biographie">
                        <i class="fas fa-user"></i>
                        <span class="nav-label">Biographie</span>
                    </a>
                </li>
                <li>
                    <a href="/EmilieHedou-php/concerts">
                        <i class="fas fa-music"></i>
                        <span class="nav-label">Concerts</span>
                    </a>
                </li>
                <li>
                    <a href="/EmilieHedou-php/#projets">
                        <i class="fas fa-star"></i>
                        <span class="nav-label">Projets</span>
                    </a>
                </li>
                <li>
                    <a href="/EmilieHedou-php/#presse">
                        <i class="fas fa-newspaper"></i>
                        <span class="nav-label">Dossier de presse</span>
                    </a>
                </li>
                <li>
                    <a href="/EmilieHedou-php/#contact">
                        <i class="fas fa-envelope"></i>
                        <span class="nav-label">Contact</span>
                    </a>
                </li>
            </ul>
            <button class="burger" id="burgerBtn" aria-label="Ouvrir le menu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </nav>
    </header>
