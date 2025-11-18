 
<?php if ($carpool['user_is_passenger'] === 1 && $carpool['status'] == 'A valider' && $carpool['user_confirmed'] === 0): ?>
    <form method="POST">
        <input type="hidden" name="carpool-id" value="<?php echo intval($carpool['id']); ?>"/>
        <input type="hidden" name="user-id" value="<?php echo intval($user['id']); ?>"/>
        <input type="hidden" name="driver-id" value="<?php echo intval($carpool['driver_id']); ?>"/>
        <button type="submit" name="validate-carpool-1" onclick="return confirm('Confirmer que ça s\'est bien passé ?');">Tout s'est bien passé</button><br>
        <button type="submit" name="validate-carpool-0">Le trajet s'est mal passé</button><br>
    </form>
<?php endif; ?>

<?php if ($user['id'] === $carpool['driver_id'] && count($reviewsReceived) !== 0) : ?>
    <?php foreach ($reviewsReceived as $review) : ?>
        <?php if ($review['carpool_id'] == $carpool['id']) : ?>
            <div style="margin-top:5px;">
                <p>Note reçue : <strong> <?php echo htmlspecialchars($review['rate']); ?> /5</strong></p><br>
                <p>Commentaire reçu : <em><?php html_entity_decode($review['commentary'], ENT_QUOTES | ENT_HTML5, 'UTF-8'); ?></em>
            </div>
        <?php endif; ?>
    <?php endforeach;?>
<?php elseif ($user['id'] !== $carpool['driver_id'] && count($reviewsLeft) !== 0) : ?>
    <?php foreach ($reviewsLeft as $review) : ?>
        <?php if ($review['carpool_id'] == $carpool['id']) : ?>
            <div style="margin-top:5px;">
                <p>Note laissée : <strong> <?php echo htmlspecialchars($review['rate']); ?> /5</strong></p><br>
                <p>Commentaire laissé : <em><?php echo html_entity_decode($review['commentary'], ENT_QUOTES | ENT_HTML5, 'UTF-8'); ?></em>
                <?php if($review['validate'] == 0): ?>
                    <span style="color: #888;">(En attente de validation)</span>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    <?php endforeach;?>
<?php else: ?>
    <form method="post" class="review-form" style="display:inline;">
        <p>Laisser un avis pour ce trajet :</p>
        <input type="hidden" name="carpool_id" value="<?php echo intval($carpool['id']); ?>"/>
        <input type="hidden" name="driver_id" value="<?php echo intval($carpool['driver_id']); ?>"/>
        <input type="number" name="rate" min="0" max="5" placeholder="note" required/>
        <input type="text" name="commentary" placeholder="Commentaire"/>
        <button type="submit" name="leave-review">Laisser un avis</button>
    </form>
<?php endif; ?>