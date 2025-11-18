<div class="security-area">
    <div class="review-form">
        <h2>Laissez un avis au conduteur</h2>
        
        <form method="POST" action="">

            <input type="number" name="user-id" value="<?php echo $d['id']; ?>" hidden />
            <input type="number" name="carpool-id" value="<?php echo $c['id']; ?>" hidden />
            <input type="number" name="driver-id" value="<?php echo $d['id']; ?>" hidden />
            <input type="number" name="rate" placeholder="Note (1 à 5)" min="1" max="5" required />
            <textarea name="commentary" placeholder="Commentaire..."></textarea>
            <button name="leave-review" type="submit">Envoyer</button>

        </form>
    </div>
</div>