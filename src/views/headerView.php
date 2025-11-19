<nav class="navbar">
    <a href="./" class="brand-area">
        <img src="./assets/images/logos/white.webp" alt="EcoRide Logo" class="navbar-logo">
        <p>EcoRide</p>
    </a>

    <button class="mobile-burger" id="mobile-burger">
        <span></span>
        <span></span>
        <span></span>
    </button>


    <div class="links-area" id="navbar-menu">
        <?php if(!$staff) : ?>
                <a class="nav-btn" href="./chercher-un-covoiturage">Covoiturages</a>
                <a class="nav-btn" href="./nous-contacter">Contact</a>
                <?php if ($connected): ?>
                    <a class="nav-btn" href="./mon-espace">Mon espace</a>
                <?php else: ?>
                    <a class="nav-btn" href="./connexion">Connexion</a>
                <?php endif; ?>
        <?php else : ?>
                <a class="nav-btn" href="./chercher-un-covoiturage">Covoiturages</a>
                <?php if ($connected): ?>
                    <?php if ($_SESSION['user_role'] === 'ADMIN'): ?>
                        <a class="nav-btn" href="./espace-admin">Mon espace</a>
                    <?php elseif ($_SESSION['user_role'] === 'STAFF'): ?>
                        <a class="nav-btn" href="./espace-staff">Mon espace</a>
                    <?php elseif ($_SESSION['user_role'] === 'USER'): ?>
                        <a class="nav-btn" href="./mon-espace">Mon espace</a>
                    <?php endif; ?>
                <?php else: ?>
                    <a class="nav-btn" href="./connexion">Connexion</a>
                <?php endif; ?>
        <?php endif; ?>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileBurger = document.getElementById('mobile-burger');
    const navbarMenu = document.getElementById('navbar-menu');
    
    if (mobileBurger && navbarMenu) {
        mobileBurger.addEventListener('click', function() {
            // Toggle du menu
            navbarMenu.classList.toggle('active');
            // Toggle de l'animation du hamburger
            mobileBurger.classList.toggle('active');
        });
        
        // Fermer le menu quand on clique sur un lien
        const navLinks = navbarMenu.querySelectorAll('a');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                navbarMenu.classList.remove('active');
                mobileBurger.classList.remove('active');
            });
        });
        
        // Fermer le menu si on clique ailleurs
        document.addEventListener('click', function(e) {
            if (!mobileBurger.contains(e.target) && !navbarMenu.contains(e.target)) {
                navbarMenu.classList.remove('active');
                mobileBurger.classList.remove('active');
            }
        });
    }
});
</script>