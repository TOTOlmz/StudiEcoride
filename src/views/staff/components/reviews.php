

<div class="review-card">
    <div class="infos">
        <span><?php echo $review['rate']; ?> /5★</span>
        <span>Covoiturage #<?php echo $review['carpool_id']; ?></span>
                        
        <p><strong>Commentaire :</strong><br> <?php echo html_entity_decode($review['commentary'], ENT_QUOTES | ENT_HTML5, 'UTF-8'); ?></p>
    </div>
    <div class="actions">
        <form method="POST" style="display: inline;">
            <input type="hidden" name="review-id" value="<?php echo $review['id'] ?>">
            <button name="validate-review" class="button">Valider</button>
        </form>
        <form method="POST" style="display: inline;">
            <input type="hidden" name="review-id" value="<?php echo $review['id'] ?>">
            <button name="reject-review" class="button">Rejeter</button>
        </form>
    </div>
</div>