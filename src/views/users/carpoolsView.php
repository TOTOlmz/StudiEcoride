<h2>Mes trajets à venir</h2>
<ul>
<?php if (!isset($activeCarpools) || count($activeCarpools) === 0): ?>
    <p>Vous n'avez pas de trajet planifié ou en cours.</p>
<?php else: ?>
    <?php foreach ($activeCarpools as $c): ?>
        <li>
            <strong><?php echo $c['user_is_passenger'] ? 'Passager' : 'Au volant'; ?></strong><br>
            <strong><?php echo htmlspecialchars($c['departure_city']); ?></strong> → <strong><?php echo htmlspecialchars($c['arrival_city']); ?></strong>
            le <?php echo htmlspecialchars($c['date']); ?> à <?php echo htmlspecialchars($c['departure_time']); ?>
            <br><?php echo htmlspecialchars($c['available_seats']); ?> réservées sur <?php echo htmlspecialchars($c['seats']); ?> places disponibles. Prix unitaire de <?php echo htmlspecialchars($c['price']); ?> Credits
            <form method="post">
                <input type="hidden" name="carpool_id" value="<?php echo intval($c['id']); ?>"/>
                <button type="submit" name="leave-carpool" onclick="return confirm('Voulez-vous vraiment annuler ce trajet ?');">
                    Annuler ce trajet
                </button>
            </form>
            <?php if (!$c['user_is_passenger']): ?>
                <form method="POST">
                    <input type="hidden" name="carpool_id" value="<?php echo intval($c['id']); ?>"/>
                    <?php if ($c['status'] == 'Planifié'): ?>
                        <button type="submit" name="start-carpool" onclick="return confirm('Démarrer ce covoiturage ?');">Démarrer le covoiturage</button><br>
                    <?php elseif ($c['status'] == 'En cours'): ?>
                        <button type="submit" name="start-carpool" onclick="return confirm('Terminer ce covoiturage ?');">Terminer le covoiturage</button><br>
                    <?php endif; ?>
                </form>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
<?php endif; ?>
</ul>

<h2>Historique de mes trajets</h2>
<ul>
<?php if (!isset($historyCarpools) || count($historyCarpools) === 0): ?>
    <p>Vous n'avez aucun trajet terminé.</p>
<?php else: ?>
    <?php foreach ($historyCarpools as $c): ?>
        <li>
            <strong><?php echo $c['user_is_passenger'] ? 'Passager' : 'Au volant'; ?></strong><br>
            <strong><?php echo htmlspecialchars($c['departure_city']); ?></strong> → <strong><?php echo htmlspecialchars($c['arrival_city']); ?></strong>
            le <?php echo htmlspecialchars($c['date']); ?> à <?php echo htmlspecialchars($c['departure_time']); ?>
            <br><?php echo htmlspecialchars($c['available_seats']); ?> réservées sur <?php echo htmlspecialchars($c['seats']); ?> places disponibles. Prix unitaire de <?php echo htmlspecialchars($c['price']); ?> Credits
            <span>(<?php echo htmlspecialchars($c['status']); ?>)</span>
            <?php if (count($reviewsLeft) === 0) : ?>
                <?php if ($user['id'] === $c['driver_id']) : ?>
                    <p>Vous ne pouvez pas laisser de commentaire si vous êtes conducteur</p>
                <?php else : ?>
                <form method="post" class="review-form">
                    <p>Laisser un avis pour ce trajet :</p>
                    <input type="hidden" name="carpool_id" value="<?php echo intval($c['id']); ?>"/>
                    <input type="hidden" name="driver_id" value="<?php echo intval($c['driver_id']); ?>"/>
                    <input type="number" name="rate" min="0" max="5" placeholder="note" required/>
                    <input type="text" name="commentary" placeholder="Commentaire"/>
                    <button type="submit" name="leave-review">Laisser un avis</button>
                </form>
                <?php endif; ?>
            <?php else: ?>
                <?php foreach ($reviewsLeft as $review) : ?>
                    <?php if ($review['carpool_id'] == $c['id']) : ?>
                        <div>
                        <p>Votre note : <strong> <?php echo htmlspecialchars($review['rate']); ?> /5</strong></p><br>
                        <p>Votre commentaire : <em><?php htmlspecialchars($review['commentary']); ?></em>
                        </div>
                    <?php endif; ?>
                <?php endforeach;?>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
<?php endif; ?>
</ul>