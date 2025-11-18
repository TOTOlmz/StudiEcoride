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
                <button type="button" onclick="history.back()">Annuler</button>
                <button name="report" type="submit">Envoyer</button>
            </div>
        </form>
    </div>
</div>


<style>

    .security-area {
        background: #00000030;
        width: 100%;
        height: 100%;
        position: fixed;
        align-content: center;
        overflow: hidden;
    }

    .report-form {
        max-width: 400px;
        margin: auto;
        padding: 20px;
        background: white;
        border-radius: 8px;
        border: 1px solid #ddd;
    }

    .report-form h2 {
        margin: 0 0 20px 0;
        text-align: center;
    }

    .report-form form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .report-form input,
    .report-form textarea {
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    .report-form textarea {
        resize: vertical;
        min-height: 80px;
    }

    .buttons {
        display: flex;
        gap: 10px;
    }

    .buttons button {
        flex: 1;
        padding: 10px;
        border: none;
        border-radius: 4px;
        font-size: 14px;
        cursor: pointer;
    }

    .buttons button:first-child {
        background: #f0f0f0;
        color: #666;
    }

    .buttons button:last-child {
        background: #d32f2f;
        color: white;
    }

    .buttons button:hover {
        opacity: 0.9;
    }
</style>