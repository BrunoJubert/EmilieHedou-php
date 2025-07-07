<footer class="site-footer">
    <div class="footer-content">
        <div class="contact-info">
            <p> <i class="fa-solid fa-phone"></i> <a href="tel:+33707070707"> 07 07 07 07 07</a></p>
            <p> <i class="fa-solid fa-envelope"></i><a href="mailto:emiliehedou77@gmail.com">
                    emiliehedou77@gmail.com</a></p>
            <a href="#admin-login-modal" id="admin-login-link" title="Connexion admin">
                <i class="fa-solid fa-lock"></i> Connexion admin</a>
            </a>
        </div>
        <div class="social-icons">
            <a href="https://www.instagram.com/emiliehedou/" target="_blank" rel="noopener" aria-label="Instagram">
                <i class="fab fa-instagram"></i>
            </a>
            <a href="https://www.facebook.com/emilie.hedou.9" target="_blank" rel="noopener" aria-label="Facebook">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="https://youtube.com/@emiliehedou5102?si=Jz-OAKKba4nGenGU" target="_blank" rel="noopener"
                aria-label="YouTube">
                <i class="fab fa-youtube"></i>
            </a>
        </div>
    </div>
    <p class="copyright">
        &copy; <span id="year"></span> <a href="https://www.bewvedtech.fr">BEWVED
            Tech.fr</a>
        Tous droits réservés.
    </p>
    <div class="rgpd">
        <p><a href="/confidentialite">Politique de confidentialité</a></p>

    </div>
    
    <div id="admin-login-modal" class="modal<?php if (!empty($showLoginModal)) echo ' show'; ?>">
    <div class="modal-content">
        <span class="close" id="close-login-modal">&times;</span>
        <form id="admin-login-form" action="/EmilieHedou-php/views/pages/login.php" method="POST">
            <h2>Connexion admin</h2>
            <label>Email :</label>
            <input type="text" name="username" required>
            <br>
            <label>Mot de passe :</label>
            <input type="password" name="password" required>
            <br>
            <button type="submit">Se connecter</button>
            <div id="login-error" style="color: red; margin-top: 10px;">
                <?php if (!empty($error)) echo htmlspecialchars($error); ?>
            </div>
        </form>
    </div>
</div>

      
      

</footer>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Gestion fermeture modale
    const modal = document.getElementById("admin-login-modal");
    const closeBtn = document.getElementById("close-login-modal");
    if (closeBtn && modal) {
        closeBtn.onclick = function () {
            modal.classList.remove("show");
        };
    }
    // Optionnel : fermer la modale si on clique en dehors
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.classList.remove("show");
        }
    };
});
</script>

  


<script src="/EmilieHedou-php/public/js/index.js"></script>
</body>

</html>