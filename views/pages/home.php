<?php
session_start();
// Connexion à la base de données (à placer tout en haut)
include_once __DIR__ . '/../../includes/db.php';

// Récupérer les 2 prochains concerts à venir
$concerts_apercu = [];
$today = date('Y-m-d');
$sql = "SELECT * FROM concerts WHERE date >= ? ORDER BY date ASC LIMIT 2";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $today);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $concerts_apercu[] = $row;
}
$stmt->close();
?>

<?php
$showLoginModal = false;
if (isset($_GET['login'])) {
    $showLoginModal = true;
}
?>

<?php include_once __DIR__ . '/../partials/header.php'; ?>

<main>
    <section id="accueil" class="landing-hero section-appear">
        <video class="landing-bg-video" autoplay muted loop playsinline>
            <source src="/public/assets/mimi_landing.mp4" type="video/mp4">
            Votre navigateur ne supporte pas la vidéo HTML5.
        </video>
        <div class="landing-content">
            <h1>Bienvenue</h1>
            <p>Découvrez l'univers musical d'<strong>Emilie Hedou</strong></p>
            <div class="landing-buttons">
                <a href="/#projets" class="see-more">Écouter un extrait</a>
                <a href="/concerts" class="see-more">Voir les concerts</a>
            </div>
        </div>
    </section>

    <section id="biographie" class="hero section-appear">
        <h1>Biographie</h1>
        <p class="bio-apercu">
            Emilie Hedou est une artiste passionnée par la musique et l'art. Elle a commencé sa carrière à un jeune âge
            et a depuis lors captivé le public avec sa voix unique et son style musical distinctif.
        </p>
        <img class="mimibw" src="/public/assets/mimi_bw.jpg" alt="Biographie Emilie" />
        <details class="see-more-dropdown" id="bio-details">
            <summary class="see-more">
                Lire la Bio
                <span class="arrow" aria-hidden="true"></span>
            </summary>
            <div class="bio-content bio-grid">
                <div class="bio-bloc bio-voix">
                    <h3>Une voix lumineuse et un lien puissant avec le public</h3>
                    <p>
                        Émilie Hédou est une boule d’énergie éclatante et positive, dont le timbre de voix unique et chaud
                        incarne à merveille les émotions brutes de la Soul Music. Sa bonne humeur communicative, son sourire
                        lumineux et sa présence charismatique marquent chaque concert. Ceux qui l’ont vue sur scène en
                        témoignent : elle crée une relation forte et authentique avec le public, faisant de chaque performance
                        un moment de partage intense. Son énergie sincère fait d’elle une artiste qui touche profondément.
                    </p>
                </div>
                <div class="bio-bloc bio-racines">
                    <h3>Des racines ancrées dans la musique noire américaine</h3>
                    <p>
                        Tout commence à l’âge de 10 ans, lorsqu’Émilie découvre dans un vieux coffre appartenant à son père un
                        vinyle oublié de gospel. Cette rencontre déclenche une véritable passion pour la musique noire
                        américaine. Elle se plonge ensuite dans l’univers de la soul des années 60, portée par la Stax et la
                        Motown, et s’imprègne des grandes voix qui ont marqué son parcours : Aretha Franklin, Otis Redding, Nina
                        Simone, Sam Cooke, Janis Joplin, Mahalia Jackson, Etta James… et Diana Ross, figure emblématique dont
                        l’élégance et la puissance vocale l’inspirent particulièrement.<br>
                        Elle se forme au Studio des Variétés à Paris, où elle étudie le chant auprès de David Féron et Claudia
                        Phillips, et l’expression scénique avec Ghislaine Lenoir. Attirée par la scène, elle se produit dans
                        toute l’Europe avec différentes formations jazz et soul, participant à des festivals prestigieux comme
                        Montreux Jazz, Jazz in Marciac, Jazz à Vannes, le Festival d’Avignon ou encore Sancy Snow Jazz. Elle
                        joue également régulièrement dans de nombreuses salles reconnues à Paris, telles que Le Bal Blomet, Le
                        Jazz Café Montparnasse, Le Pan Piper ou encore Le Méridien Jazz Club Étoile.
                    </p>
                </div>
                <div class="bio-bloc bio-image">
                    <img class="mimi-bio" src="/public/assets/mimipresse.jpg" alt="Emilie Hedou" />
                </div>
                <div class="bio-bloc bio-univers">
                    <h3>Un univers personnel entre reprises, compositions et théâtre</h3>
                    <p>
                        En parallèle de ses prestations en groupe, Émilie monte son propre trio en 2014, après plusieurs années
                        à s’accompagner à la guitare. Avec Nicolas Blampain (guitare) et Hervé Pouliquen (contrebasse), elle
                        revisite les classiques de ses idoles — Etta James, Ray Charles, Nina Simone, Janis Joplin, Otis Redding
                        — et propose des compositions personnelles, toujours empreintes de soul et de blues.<br>
                        En 2013, elle écrit et compose le spectacle musical “Tel frère, telle sœur”, présenté au Festival
                        d’Avignon. Elle rend également hommage à Aretha Franklin au sein du groupe “Soul Serenade”, entourée de
                        musiciens talentueux comme Michel Bonnet, Pierre-Louis Cas, Pierre Guicquéro, Pierre Jean, Laurent
                        Vanhée et Michel Sénamaud. Ensemble, ils interprètent les grands standards de la soul des années 60.<br>
                        Émilie explore aussi l’univers théâtral à travers des spectacles comme “Carnet de notes” (2017) et “A
                        Christmas Carol” (2023). Ce parcours riche et pluriel témoigne de sa passion profonde pour la scène et
                        de son engagement artistique.
                    </p>
                </div>
            </div>
        </details>
    </section>

    <section id="concerts" class="hero section-appear">
    <h1>Concerts</h1>
    <p>Bientôt en concert près de chez vous</p>
    <img class="mimichant" src="/public/assets/mimi1.jpg" alt="Concerts Emilie" />

    <?php if (empty($concerts_apercu)) : ?>
        <p style="margin-top:1em;">Aucun concert à venir pour le moment.</p>
    <?php else : ?>
        <div class="concert-cards-grid">
            <?php foreach ($concerts_apercu as $concert) : ?>
                <?php
                    $bgImage = '';
                    if (!empty($concert['image_url'])) {
                        $src = htmlspecialchars($concert['image_url']);
                        if (strpos($src, 'http') !== 0 && strpos($src, '/') !== 0) {
                            $src = '/EmilieHedou-php/public/assets/' . $src;
                        }
                        $bgImage = "background-image: url('{$src}');";
                    }
                ?>
                <div class="concert-card" style="<?= $bgImage ?>">
                    <div class="concert-card-content">
                        <h3 class="concert-artist"><?= htmlspecialchars($concert['artist']) ?></h3>
                        <?php if (!empty($concert['description'])) : ?>
                            <p class="concert-description"><?= htmlspecialchars($concert['description']) ?></p>
                        <?php endif; ?>
                        <div class="concert-info">
                            <span class="concert-venue"><?= htmlspecialchars($concert['venue']) ?></span>
                            <span class="concert-date">
                                <?= date('d/m/Y', strtotime($concert['date'])) ?>
                            </span>
                            <?php if (!empty($concert['time'])) : ?>
                                <span class="concert-time">à <?= substr($concert['time'], 0, 5) ?></span>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($concert['price']) && $concert['price'] > 0) : ?>
                            <p class="concert-price"><strong>Prix :</strong> <?= number_format($concert['price'], 2) ?> €</p>
                        <?php endif; ?>
                        <?php if (!empty($concert['phone'])) : ?>
                        <div class="concert-phone">
                            <span class="phone-number"><?= htmlspecialchars($concert['phone']) ?></span>
                            <a href="tel:<?= htmlspecialchars($concert['phone']) ?>"
                               class="btn-call"
                               title="Appeler pour réserver">
                                Téléphoner
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <a href="/concerts" class="see-more" style="margin-top:2em;display:inline-block;"><strong>Voir les dates</strong></a>
</section>




<section id="projets" class="hero section-appear">
    <h1>Projets</h1>
    <p>Retrouvez dans cette section les projets auxquels <strong>Emilie</strong> participe <br>
       ainsi que les vidéos de ses performances.</p>                     
    </p>
    <img class="mimiprojet" src="/public/assets/mimi-projet.png" alt="Projets Emilie" />
    <details class="see-more-dropdown" id="bio-details">   
        <summary class="see-more">
            Explorer
            <span class="arrow" aria-hidden="true"></span>
        </summary> 
        <div class="projets-videos">
            <div class="projet-video-bloc">
                <h3>Emilie HEDOU Trio</h3>
                <p>Un trio original où guitare et contre basse accompagnent la voix suave et puissante d' <strong>Emilie</strong>.
                    Un voyage musical à travers les classiques de la soul et du blues, avec des compositions 
                    personnelles et des arrangements uniques. 
                    Dans cette vidéo, vous découvrirez une composition originale d'<strong>Emilie Hedou</strong>  avec des arrangements de <a href="https://www.youtube.com/channel/UCBvrYWYNEgNa8AG8K8oO3Ag"><strong>Nicolas Blampain</strong></a>.
                    Ils sont accompagnés de <strong>Brahim Haiouani</strong> à la contrebasse.
                </p>
                <div class="video-wrapper">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/HlU5LDiVopo?si=46SPc0hl_brp33pL" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; 
                    encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
            </div>
            <div class="projet-video-bloc">
                <h3>Soul Serenade avec Emilie Hedou</h3>
                <p>
                    Un hommage vibrant a la soul music, d' <strong>Aretha Franklin</strong> à <strong>Ray Charles</strong>,
                    ce projet met en lumière les classiques intemporels des plus grandes voix de la soul, interprétés par la voix puissante et émotive d'<strong>Emilie Hedou</strong>.
                    Dans cette vidéo, vous découvrirez une performance live du groupe Soul Serenade avec une distrubution de musiciens talentueux :
                    <br>
                    <strong>Michel Bonnet</strong> (Trompette, Choeur), 
                    <strong>Pierre-Louis Cas</strong> (Sax Ténor, Choeur), 
                    <strong>Pierre Guicquéro</strong> (Trombonne, Choeur), 
                    <strong>Pierre Jean</strong> (Piano, Clavier), 
                    <strong>Laurent Vanhée</strong> (Contre basse) 
                    et <strong>Michel Sénamaud</strong> (Batterie, Choeur).
                </p>
                <div class="video-wrapper">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/kpq7Hi9F2ec?si=gW6BQVyJHHGm1OgK" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture;
                     web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
            </div>
            <div class="projet-video-bloc">
                <h3>Paris Soul Connexion</h3>
                <p>
                    Un projet qui réunit des artistes de la scène soul parisienne pour créer une connexion musicale unique.
                    <strong>Emilie Hedou</strong> y apporte sa touche personnelle et sa voix envoûtante, accompagnée de musiciens de renom.
                    Dans cette vidéo, vous découvrirez un extrait d'une performance live du groupe Paris Soul Connexion.
                    mettant en avant le duo : <strong>Emilie Hedou</strong> ainsi que de <strong>Jean-Marrier</strong>.
                    Ils sont ici accompagnés de musiciens de renommée mondiale : 
                    <br>
                    <strong>Benoît Sourisse</strong> ( Orgue Hammond, Clavier),
                    <strong>Lemmy Feuvray</strong> (Guitare),
                    <strong>André Charlier</strong> : (Batterie).
        

                </p>
                <div class="video-wrapper">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/rYVZ71Vv45g?si=iwA3_wyvYHsjVBG2" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; 
                    web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </details>   
</section>


    <section id="presse" class="hero section-appear">
  <h1>Kit presse</h1>
  <p>
    Retrouvez ici le kit presse d'Emilie Hedou, contenant des informations sur sa carrière, ses projets
    et ses concerts. Ce kit est destiné aux journalistes, blogueurs et professionnels de l'industrie musicale.
  </p>

  <details class="see-more-dropdown" id="kit-details">  
    <summary class="see-more">
      Découvrir
      <span class="arrow" aria-hidden="true"></span>
    </summary> 

    <div class="kit">
      <img src="/public/assets/kit_presse_recto.jpg" alt="Dossier de presse Emilie - Recto" />
      <img src="/public/assets/kit_presse_verso.jpg" alt="Dossier de presse Emilie - Verso" />
    </div>

    <a href="/public/assets/kit_presse.pdf" download class="btn-download-pdf" aria-label="Télécharger le kit presse au format PDF">
      Télécharger le kit presse (PDF)
    </a>
  </details>    
</section>



    <section id="contact" class="contact-section hero section-appear">
        <h1>Contact</h1>
        <form action="https://formspree.io/f/movevnek" method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required />
            </div>
            <div class="form-group">
                <label for="subject">Sujet</label>
                <select id="subject" name="subject" required>
                    <option value="" disabled selected>Sélectionnez...</option>
                    <option value="Concerts">Demande de concert</option>
                    <option value="Projets">Collaboration artistique</option>
                    <option value="Presse">Presse/Interview</option>
                    <option value="Autre">Autre demande</option>
                </select>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea id="message" name="message" rows="6" required></textarea>
            </div>
            <button type="submit" class="submit"><strong>Envoyer</strong></button>
        </form>
    </section>
</main>

<?php include_once __DIR__ . '/../partials/footer.php'; ?>
