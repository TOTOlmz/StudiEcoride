
<div class="profile-header">
    <h2>Mon espace</h2>
    <form method="post">
        <button type="submit" class="button" name="logout">Se déconnecter</button>
    </form>
</div>

<div class="profile-section">
    <div>
        <div>
            <img class="profile-picture"
            src="<?php echo isset($user['photo']) ? '../src/assets/images/users/' . html_entity_decode($user['photo'], ENT_QUOTES | ENT_HTML5, 'UTF-8') : '../src/assets/images/users/default.png'; ?>"
            alt="Photo de profil"/>
            <div>
                <p><strong><?php echo ucfirst(html_entity_decode($user['pseudo'], ENT_QUOTES | ENT_HTML5, 'UTF-8')); ?></strong></p>
                <p><strong>Crédits :</strong> <?php echo intval($user['credits']); ?></p>
            </div>
        </div>

        <?php if (isset($averageRate) && $averageRate !== null): ?>
            <div>
                <p>Moyenne : <strong><?php echo floatval($averageRate) . '★'; ?> </strong> | <a href="./mes-avis"> Voir mes avis</a></p>
            </div>
        <?php else: ?>
            <div>
                <p>Vous n'avez pas encore d'avis.</p>
            </div>
        <?php endif; ?>
    </div>
    <form action="" method="POST" enctype="multipart/form-data">
        <input class="form-group" type="file" accept="image/*" id="addPicture" name="photo" required />
        <button type="submit" class="button">Changer la photo</button>
    </form>
</div>



<div class="review-cards">
    
    
</div>
