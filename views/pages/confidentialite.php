<?php
$showLoginModal = false;
if (isset($_GET['login'])) {
    $showLoginModal = true;
}
?>


<?php include_once __DIR__ . '/../partials/header.php'; ?>

<main>
    <section id="confidentialite">
        <div class="hero">
            <h2>Politique de Confidentialité</h2>
            <p>Dernière mise à jour : 29 AVRIL 2025</p>

            <h3>Collecte de données</h3>
            <p>Notre site ne collecte aucune donnée personnelle directement. Nous n'utilisons pas de cookies ni de
                systèmes de suivi des utilisateurs.</p>

            <h3>Liens externes et partage</h3>
            <p>Ce site contient des liens vers des sites externes (YouTube, Facebook et InstaGram).
                Veuillez noter que ces sites tiers ont leurs propres politiques de
                confidentialité sur lesquelles nous n'avons aucun contrôle. En particulier, les vidéos YouTube
                intégrées peuvent déposer des cookies conformément à la politique de Google. Nous vous invitons à
                consulter la politique de confidentialité de Google pour plus d'informations.</p>

            <h3>Droits des utilisateurs</h3>
            <p>Conformément au Règlement Général sur la Protection des Données (RGPD), vous disposez de droits
                concernant vos données personnelles, notamment le droit d'accès, de rectification et de suppression.
                Bien que nous ne collections pas directement de données, ces droits s'appliquent aux informations
                que vous pourriez partager via les liens externes.</p>

            <h3>Mises à jour de la politique</h3>
            <p>Cette politique peut être mise à jour à tout moment. Les utilisateurs peuvent demander la dernière
                version par email.</p>

            <h3>Contact</h3>
            <p>Pour toute question concernant cette politique de confidentialité ou pour demander une mise à jour,
                vous pouvez nous contacter à l'adresse suivante : <a
                    href="mailto:emiliehedou77@gmail.com">emiliehedou77@gmail.com</a></p>
        </div>
    </section>
</main>

<?php include_once __DIR__ . '/../partials/footer.php'; ?>
