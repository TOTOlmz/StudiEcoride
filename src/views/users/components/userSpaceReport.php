<div class="security-area">
    <div class="report-form">
        <h2>Expliquez nous le problème</h2>
        
        <form method="POST" action="">

            <input type="number" name="user-id" value="<?php echo $u['id']; ?>" hidden />
            <input type="text" name="user-email" value="<?php echo $u['email']; ?>" hidden />
            <input type="text" name="user-pseudo" value="<?php echo $u['pseudo']; ?>" hidden />
            <input type="number" name="driver-id" value="<?php echo $d['id']; ?>" hidden />
            <input type="text" name="driver-email" value="<?php echo $d['email'];  ?>" hidden />
            <input type="text" name="driver-pseudo" value="<?php echo $d['pseudo']; ?>" hidden />
            <input type="number" name="carpool-id" value="<?php echo $c['id']; ?>" hidden />
            <input type="number" name="carpool-id" value="<?php echo $c['date']; ?>" hidden />
            <input type="text" name="departure-city" value="<?php echo $c['departure_city']; ?>" hidden />
            <input type="text" name="departure-time" value="<?php echo $c['departure_time']; ?>" hidden />
            <input type="text" name="arrival-city" value="<?php echo $c['arrival_city']; ?>" hidden />
            <input type="text" name="arrrival-time" value="<?php echo $c['arrival_time']; ?>" hidden />
            
            <input type="text" name="subject" placeholder="Objet du problème" required maxlength="100">
            
            <textarea name="description" placeholder="Décrivez le problème..." required rows="4"></textarea>
            
            <div class="buttons">
                <button class="button" type="button" onclick="history.back()">Annuler</button>
                <button class="button" name="report" type="submit">Envoyer</button>
            </div>
        </form>
    </div>
</div>

