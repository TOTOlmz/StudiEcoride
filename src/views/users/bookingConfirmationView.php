


<?php if (isset($success) && $success == true): ?>
    <div class="form-container">
        <h2>Réservation confirmée !</h2>
        <p> vous partez pour <strong><?php echo $carpool['arrival_city']; ?></strong> !</p>
        <p>Vous avez réservé : <?php echo intval($seats) > 1 ? $seats . ' sièges' : $seats . ' siège'; ?></p>
        <p>Crédits débités : <?php echo intval($seats) > 1 ? $cost . ' (' . $seats . 'x' . $price . ')' : $cost; ?></p>

        <a href="./chercher-un-covoiturage" class="button">Rechercher un autre covoiturage</a>
        <a href="./mon-espace" class="button">Mon espace</a>
    </div>
<?php else: ?>
    <h2>Page dédier à la reservation de covoiturages. vous avez perdu votre chemin</h2>
    <a href="./">Retour à l'accueil</a>
<?php endif; ?>