
<?php if (count($cars) > 0): ?>
    <h2>Mes covoiturages <a href="./proposer-un-covoiturage">✚</a></h2>
<?php else: ?>
    <h2>Mes covoiturages <a href="./ajouter-un-vehicule">✚</a></h2>
<?php endif; ?>

<?php if (count($cars) > 0): ?>
    <a href="./proposer-un-covoiturage">Ajouter un trajet</a>
<?php else: ?>
    <p>Ajoutez un véhicule pour devenir chauffeur et pouvoir proposer un trajet. <a href="./ajouter-un-vehicule">Ajouter un véhicule</a></p>
<?php endif; ?>


<div class="carpool-cards">
    <?php if (isset($activeCarpools) && count($activeCarpools) > 0): ?>
        <?php foreach ($activeCarpools as $c): ?>
            <div class="carpool-card">
                <strong><?php echo $c['user_is_passenger'] ? 'Passager' : 'Au volant'; ?></strong><br>
                <strong><?php echo html_entity_decode($c['departure_city'], ENT_QUOTES | ENT_HTML5, 'UTF-8'); ?></strong> → <strong><?php echo html_entity_decode($c['arrival_city'], ENT_QUOTES | ENT_HTML5, 'UTF-8'); ?></strong>
                le <?php echo htmlspecialchars($c['date']); ?> à <?php echo substr(htmlspecialchars($c['departure_time']), 0, 5); ?>
                <br><?php echo intval($c['seats']) - intval($c['available_seats']); ?> réservées sur <?php echo htmlspecialchars($c['seats']); ?> places disponibles. Prix unitaire de <?php echo htmlspecialchars($c['price']); ?> Credits
                <br><em><?php echo htmlspecialchars($c['status']); ?></em>
                <?php if ($c['status'] === 'Planifié'): ?>    
                    <form method="post">
                        <input type="hidden" name="carpool-id" value="<?php echo intval($c['id']); ?>"/>
                        <button type="submit" class="button" name="leave-carpool" onclick="return confirm('Voulez-vous vraiment annuler ce trajet ?');">Annuler ce trajet</button>
                    </form>
                <?php endif; ?>
                <?php if (!$c['user_is_passenger']): ?>
                    <form method="POST">
                        <input type="hidden" name="carpool-id" value="<?php echo intval($c['id']); ?>"/>
                        <?php if ($c['status'] == 'Planifié'): ?>
                            <button type="submit" class="button" name="update-carpool" onclick="return confirm('Démarrer ce covoiturage ?');">Démarrer le covoiturage</button><br>
                            <input type="hidden" class="button" name="carpool-status" value="En cours"/>
                        <?php elseif ($c['status'] == 'En cours'): ?>
                            <button type="submit" name="update-carpool" onclick="return confirm('Terminer ce covoiturage ?');">Terminer le covoiturage</button><br>
                            <input type="hidden" name="carpool-status" value="A valider"/>
                        <?php endif; ?>
                    </form>
                <?php elseif ($c['user_is_passenger'] && $c['status'] == 'A valider' && $c['user_confirmed'] === 0): ?>
                    <form method="POST" class="two-buttons-form">
                        <input type="hidden" name="carpool-id" value="<?php echo intval($c['id']); ?>"/>
                        <input type="hidden" name="user-id" value="<?php echo intval($user['id']); ?>"/>
                        <input type="hidden" name="driver-id" value="<?php echo intval($c['driver_id']); ?>"/>
                        <button type="submit" class="button" name="validate-carpool-1" onclick="return confirm('Confirmer que ça s\'est bien passé ?');">Tout s'est bien passé</button><br>
                        <button type="submit" class="button" name="validate-carpool-0">Le trajet s'est mal passé</button><br>
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php elseif (!isset($activeCarpools) || count($activeCarpools) === 0): ?>
    <p>Vous n'avez pas de trajets en cours.</p>
    <?php endif; ?>
    <?php if (isset($historyCarpools) && count($historyCarpools) > 0): ?>
        <a href="./historique-des-covoiturages">Consultez l'ensemble de vos trajets.</a>
    <?php endif; ?>
</div>