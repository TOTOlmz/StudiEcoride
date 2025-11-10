<nav class="navbar" style="height:60px; overflow:hidden;">
    <a href="./" class="brand-area">
        <img src="../src/assets/images/logos/white.webp" alt="EcoRide Logo" class="navbar-logo">
        <p>EcoRide</p>
    </a>
    <?php if(!$staff) : ?>
        <div class="links-area">
            <a class="nav-btn" href="./trajets">Covoiturages</a>
            <a class="nav-btn" href="./contact">Contact</a>
            <?php if ($connected): ?>
                <a class="nav-btn" href="./mon-espace">Mon espace</a>
            <?php else: ?>
                <a class="nav-btn" href="./connexion">Connexion</a>
            <?php endif; ?>
        </div>
    <?php else : ?>
        <div class="links-area">
            <a class="nav-btn" href="./trajets">Covoiturages</a>
            <?php if ($connected): ?>
                <a class="nav-btn" href="./mon-espace">Mon espace</a>
                <a class="nav-btn" href="./contact">Déconnexion</a>
            <?php else: ?>
                <a class="nav-btn" href="./connexion">Connexion</a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</nav>