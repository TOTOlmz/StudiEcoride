<?php if (count($results) > 0 && $suggestion == false): ?>
    <?php foreach ($results as $carpool): ?>
        <div class="carpool-card" 
            data-eco="<?php echo intval($carpool['is_ecological']); ?>" 
            data-price="<?php echo floatval($carpool['price']); ?>" 
            data-duration="<?php echo $carpool['duration']; ?>"
            data-rate="<?php echo floatval($carpool['driver_rate']); ?>">
            <div class="card-top">
                <div class="driver">
                    <img src="./../src/assets/images/users/<?php echo $carpool['driver_photo']; ?>" alt="Photo de <?php echo $carpool['driver_pseudo']; ?>" style="width:40px; height:40px; border-radius:50%; margin-right:10px;">
                    <strong><?php echo $carpool['driver_pseudo']; ?></strong>
                    <span class="rating">★ <?php echo $carpool['driver_rate']; ?></span>
                </div>
                <div class="bubble"><?php echo htmlspecialchars($carpool['price']); ?>€</div>
            </div>
            
            <div class="trip">
                <span><?php echo $carpool['departure_city']; ?><br>
                <?php echo $carpool['departure_time']; ?></span>
                <span class="arrow">➜</span>
                <span><?php echo $carpool['arrival_city']; ?><br>
                <?php echo $carpool['arrival_time']; ?></span>
            </div>
            
            <div class="details">
                <span>Écologique : <?php echo $carpool['is_ecological'] ? '✔' : '✖'; ?></span>
                <span><?php echo $carpool['date'] ?></span>
                <span><?php echo $carpool['show_duration'] ?></span>
                <span><?php echo $carpool['available_seats'] ?>/<?php echo $carpool['seats'] ?> places</span>
                
                <a href="./details-du-covoiturage?c=<?php echo $carpool['id']; ?>">Voir les détails</a>
            </div>
        </div>
    <?php endforeach; ?>
<?php elseif ($suggestion === true): ?>
    <?php $carpool = $results[0]; ?>
    <p>Aucun covoiturage trouvé pour votre date. Nous vous proposons de voyager le <?php echo $carpool['date']; ?> : </p>
    <div class="carpool-card" 
        data-eco="<?php echo intval($carpool['is_ecological']); ?>" 
        data-price="<?php echo floatval($carpool['price']); ?>" 
        data-duration="<?php echo $carpool['duration']; ?>"
        data-rate="<?php echo floatval($carpool['driver_rate']); ?>">
        <div class="card-top">
            <div class="driver">
                <img src="./../src/assets/images/users/<?php echo $carpool['driver_photo']; ?>" alt="Photo de <?php echo $carpool['driver_pseudo']; ?>" style="width:40px; height:40px; border-radius:50%; margin-right:10px;">
                <strong><?php echo $carpool['driver_pseudo']; ?></strong>
                <span class="rating">★ <?php echo $carpool['driver_rate']; ?></span>
            </div>
            <div class="bubble"><?php echo htmlspecialchars($carpool['price']); ?>€</div>
        </div>
        
        <div class="trip">
            <span><?php echo $carpool['departure_city']; ?><br>
            <?php echo $carpool['departure_time']; ?></span>
            <span class="arrow">➜</span>
            <span><?php echo $carpool['arrival_city']; ?><br>
            <?php echo $carpool['arrival_time']; ?></span>
        </div>
        
        <div class="details">
            <span>Écologique : <?php echo $carpool['is_ecological'] ? '✔' : '✖'; ?></span>
            <span><?php echo $carpool['date'] ?></span>
            <span><?php echo $carpool['show_duration'] ?></span>
            <span><?php echo $carpool['available_seats'] ?>/<?php echo $carpool['seats'] ?> places</span>
            
            <a href="./details-du-covoiturage?c=<?php echo $carpool['id']; ?>">Voir les détails</a>
        </div>
    </div>
<?php else: ?>
    <p>Aucun covoiturage trouvé pour votre recherche.</p>
<?php endif; ?>

