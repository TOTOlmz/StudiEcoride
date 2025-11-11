<h1>Mon espace</h1>
<form method="post" style="margin-bottom:2rem">
    <button type="submit" name="logout">Se déconnecter</button>
</form>
    <?php if (!empty($errors)): ?>
        <div class="errors">
            <?php foreach ($errors as $error): ?>
                <p style="color:red"><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php elseif (!empty($success)): ?>
        <div class="success">
            <p style="color:green"><?= htmlspecialchars($success) ?></p>
        </div>
    <?php endif; ?>
<!-- Section reservée au profil -->
<?php if (!empty($user)): ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <img class="profil-picture"
            src="<?php echo isset($user['photo']) ? '../src/assets/images/users/' . htmlspecialchars($user['photo']) : '../src/assets/images/users/default.png'; ?>"
            style="border-radius:50%; object-fit:cover;"
            alt="Photo de profil" width="150" height="150"/>
        <input type="file" accept="image/*" id="addPicture" name="photo" required />
        <button type="submit">Changer la photo</button>
    </form>

    <p><strong>Pseudo :</strong> <?php echo htmlspecialchars($user['pseudo']); ?></p>
    <p><strong>Crédits :</strong> <?php echo htmlspecialchars($user['credits']); ?></p>
    <?php if (isset($averageRate) && $averageRate !== null): ?>
        <p>votre moyenne </p>
        <p> <?php  echo floatval($averageRate) . ' sur 5';   ?> </p>
        <a href="./mes-avis">Voir mes avis</a>
    <?php else: ?>
        <p>Vous n'avez pas encore d'avis.</p>
    <?php endif; ?>
<?php endif; ?>

<!-- Section reservée aux covoiturages -->
<h2>Mes covoiturages</h2>
<?php if (count($cars) > 0): ?>
    <a href="./proposer-un-covoiturage">Ajouter un trajet</a>
<?php else: ?>
    <p>Ajoutez un véhicule pour devenir chauffeur et pouvoir proposer un trajet. </p>
    <a href="./ajouter-un-vehicule">Ajouter un véhicule</a>
<?php endif; ?>


<ul>
<?php if (isset($activeCarpools) && count($activeCarpools) > 0): ?>
<?php foreach ($activeCarpools as $c): ?>
    <li>
        <strong><?php echo $c['user_is_passenger'] ? 'Passager' : 'Au volant'; ?></strong><br>
        <strong><?php echo htmlspecialchars($c['departure_city']); ?></strong> → <strong><?php echo htmlspecialchars($c['arrival_city']); ?></strong>
        le <?php echo htmlspecialchars($c['date']); ?> à <?php echo htmlspecialchars($c['departure_time']); ?>
        <br><?php echo htmlspecialchars($c['available_seats']); ?> réservées sur <?php echo htmlspecialchars($c['seats']); ?> places disponibles. Prix unitaire de <?php echo htmlspecialchars($c['price']); ?> Credits
        <form method="post" style="display:inline;">
            <input type="hidden" name="carpool_id" value="<?php echo intval($c['id']); ?>"/>
            <button type="submit" name="leave-carpool" onclick="return confirm('Voulez-vous vraiment annuler ce trajet ?');">
                Annuler ce trajet
            </button>
        </form>
        <?php if (!$c['user_is_passenger']): ?>
            <form method="POST">
                <input type="hidden" name="carpool_id" value="<?php echo intval($c['id']); ?>"/>
                <?php if ($c['status'] == 'Planifié'): ?>
                    <button type="submit" name="update-carpool" onclick="return confirm('Démarrer ce covoiturage ?');">Démarrer le covoiturage</button><br>
                <?php elseif ($c['status'] == 'En cours'): ?>
                    <button type="submit" name="update-carpool" onclick="return confirm('Terminer ce covoiturage ?');">Terminer le covoiturage</button><br>
                <?php endif; ?>
            </form>
        <?php endif; ?>
    </li>
<?php endforeach; ?>
<?php elseif (!isset($activeCarpools) || count($activeCarpools) === 0): ?>
    <p>Vous n'avez pas de trajets en cours.</p>
<?php endif; ?>
<?php if (isset($historyCarpools) && count($historyCarpools) > 0): ?>
    <a href="./historique-des-covoiturages">Consultez l'ensemble de vos trajets.</p>
<?php endif; ?>
</ul>

<!-- Section reservée aux vehicules -->
<h2>Mes véhicules</h2>
<a href="./ajouter-un-vehicule">Ajouter un véhicule</a>
<?php if (empty($cars)): ?>
    <p>Aucun véhicule renseigné.</p>
<?php else: ?>
    <ul>
        <?php foreach ($cars as $car): ?>
            <li>
                <strong><?php echo $car['brand'] . ' ' . $car['model']; ?></strong><br>
                <p>Couleur : <?php echo htmlspecialchars($car['color']) ?>. Energie : <?php echo htmlspecialchars($car['energy']); ?>
                <p>Immatriculation : <?php echo htmlspecialchars($car['plate_number']); ?></p>
                <p>Date de 1<sup>ère</sup> mise en circulation : <?php echo htmlspecialchars($car['first_registration']); ?></p>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>


