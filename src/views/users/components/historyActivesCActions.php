<?php if ($carpool['status'] === 'Planifié'): ?>    
    <form method="post" style="display:inline;">
        <input type="hidden" name="carpool-id" value="<?php echo intval($carpool['id']); ?>"/>
        <button type="submit" name="leave-carpool" onclick="return confirm('Voulez-vous vraiment annuler ce trajet ?');">Annuler ce trajet</button>
    </form>
<?php endif; ?>
<?php if ($carpool['user_is_passenger'] === 0): ?>
    <form method="POST">
        <input type="hidden" name="carpool-id" value="<?php echo intval($carpool['id']); ?>"/>
        <?php if ($carpool['status'] == 'Planifié'): ?>
            <button type="submit" name="update-carpool" onclick="return confirm('Démarrer ce covoiturage ?');">Démarrer le covoiturage</button><br>
            <input type="hidden" name="carpool-status" value="En cours"/>
        <?php elseif ($carpool['status'] == 'En cours'): ?>
            <button type="submit" name="update-carpool" onclick="return confirm('Terminer ce covoiturage ?');">Terminer le covoiturage</button><br>
            <input type="hidden" name="carpool-status" value="A valider"/>
        <?php endif; ?>
    </form>
<?php endif; ?>

