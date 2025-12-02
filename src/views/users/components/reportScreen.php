<div class="security-area">
    <div class="form-container">
        <h2>Expliquez nous le problème</h2>
        
        <form class="form-group" method="POST" action="">

            <input type="number" name="user-id" value="<?php echo $u['id']; ?>" hidden />
            <input type="text" name="user-email" value="<?php echo $u['email']; ?>" hidden />
            <input type="text" name="user-pseudo" value="<?php echo $u['pseudo']; ?>" hidden />
            <input type="number" name="driver-id" value="<?php echo $d['id']; ?>" hidden />
            <input type="text" name="driver-email" value="<?php echo $d['email'];  ?>" hidden />
            <input type="text" name="driver-pseudo" value="<?php echo $d['pseudo']; ?>" hidden />
            <input type="number" name="carpool-id" value="<?php echo $c['id']; ?>" hidden />
            <input type="date" name="date" value="<?php echo $c['date']; ?>" hidden />
            <input type="text" name="departure-city" value="<?php echo $c['departure_city']; ?>" hidden />
            <input type="text" name="departure-time" value="<?php echo $c['departure_time']; ?>" hidden />
            <input type="text" name="arrival-city" value="<?php echo $c['arrival_city']; ?>" hidden />
            <input type="text" name="arrival-time" value="<?php echo $c['arrival_time']; ?>" hidden />
            <div class="form-group">
                <input type="text" name="subject" placeholder="Objet du problème" required maxlength="100">
            </div>
            <div class="form-group">         
                <textarea name="description" placeholder="Décrivez le problème..." required rows="4"></textarea>
            </div>      
            <div class="buttons">
                <button class="button" type="button" id="close">Annuler</button>
                <button class="button" name="report" type="submit">Envoyer</button>
            </div>
        </form>
    </div>
</div>
<script>
    const closeBtn = document.getElementById('close');
    const reportArea = document.querySelector('.security-area');

    // Si on appuie sur annuler
    closeBtn.addEventListener('click', () => {
        reportArea.hidden = true;
        window.location.href = window.location.pathname; // On vide le POST en rechargeant la page

    });

    // Si on clique en dehors du formulaire
    reportArea.addEventListener('click', (e) => {
        if (e.target === e.currentTarget) {
            reportArea.hidden = true;
            window.location.href = window.location.pathname; // On vide le POST en rechargeant la page
        }
    });


</script>