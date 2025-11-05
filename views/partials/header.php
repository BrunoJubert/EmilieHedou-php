<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Encodage et responsive -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Vérification Google -->
    <meta name="google-site-verification" content="6KDIzMITTOFk3S_eWxow6bPz9jhdJLaqJ0vqiZ6Dj7Y" />

    <!-- Titre SEO -->
    <title>Emilie Hedou – Chanteuse Soul & Blues, Concerts et Projets Musicaux</title>

    <!-- Meta description pour Google -->
    <meta name="description" content="Site officiel d'Emilie Hedou – Chanteuse Soul & Blues, Concerts et Projets Musicaux">

    <!-- Meta keywords (optionnel) -->
    <meta name="keywords" content="Emilie Hedou, chanteuse, soul, blues, concerts, vidéos, musique, projets musicaux">

    <!-- Canonical URL pour éviter le contenu dupliqué -->
    <link rel="canonical" href="https://www.emiliehedou.fr/">

    <!-- Open Graph pour Facebook / LinkedIn -->
    <meta property="og:title" content="Emilie Hedou – Chanteuse Soul & Blues">
    <meta property="og:description" content="Découvrez le site officiel d’Emilie Hedou : concerts, vidéos et projets musicaux.">
    <meta property="og:image" content="https://www.emiliehedou.fr/public/assets/mimi1.jpg">
    <meta property="og:url" content="https://www.emiliehedou.fr">
    <meta property="og:type" content="website">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Emilie Hedou – Chanteuse Soul & Blues">
    <meta name="twitter:description" content="Découvrez le site officiel d’Emilie Hedou : concerts, vidéos et projets musicaux.">
    <meta name="twitter:image" content="https://www.emiliehedou.fr/public/assets/mimi1.jpg">

    <!-- /* Favicon */ -->
    <link rel="icon" type="image/png" href="/public/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/public/favicon/favicon.svg" />
    <link rel="shortcut icon" href="/public/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/public/favicon/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="Emilie Hedou" />
    <link rel="manifest" href="/public/favicon/site.webmanifest" />

    <!-- Fonts & Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="/public/styles/styles.css" />
    <?php if (isset($page) && $page === 'concerts') : ?>
        <link rel="stylesheet" href="/public/styles/concert.css" />
    <?php endif; ?>

    <!-- Script cookies -->
    <script src="/public/js/coockieManager.js"></script>
    <!-- JSON-LD pour Emilie Hedou -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Person",
  "name": "Emilie Hedou",
  "image": "https://www.emiliehedou.fr/public/assets/mimi1.jpg",
  "url": "https://www.emiliehedou.fr",
  "sameAs": [
    "https://www.facebook.com/emilie.hedou.9",
    "https://www.instagram.com/emiliehedou/",
    "https://youtube.com/@emiliehedou5102?si=Jz-OAKKba4nGenGU"
  ],
  "jobTitle": "Chanteuse Soul & Blues"
}
</script>

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
                    <a href="/dashboard">
                        <i class="fas fa-gauge"></i>
                        <span class="nav-label">Dashboard</span>
                    </a>
                </li>
            <?php endif; ?>
                <li>
                    <a href="/">
                        <i class="fas fa-home"></i>
                        <span class="nav-label">Accueil</span>
                    </a>
                </li>
                <li>
                    <a href="/#biographie">
                        <i class="fas fa-user"></i>
                        <span class="nav-label">Biographie</span>
                    </a>
                </li>
                <li>
                    <a href="/concerts">
                        <i class="fas fa-music"></i>
                        <span class="nav-label">Concerts</span>
                    </a>
                </li>
                <li>
                    <a href="/#projets">
                        <i class="fas fa-star"></i>
                        <span class="nav-label">Projets</span>
                    </a>
                </li>
                <li>
                    <a href="/#presse">
                        <i class="fas fa-newspaper"></i>
                        <span class="nav-label">Docs</span>
                    </a>
                </li>
                <li>
                    <a href="/#contact">
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
