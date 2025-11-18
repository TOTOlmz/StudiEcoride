
<div class="card-top">
    <div class="driver">
        <img src="./../src/assets/images/users/<?php echo $carpool['driver_photo']; ?>" alt="Photo de <?php echo $carpool['driver_pseudo']; ?>" style="width:40px; height:40px; border-radius:50%; margin-right:10px;">
        <strong><?php echo $carpool['driver_pseudo']; ?></strong>
    </div>
</div>

<div class="trip">
    <span><?php echo $carpool['departure_city']; ?><br>
    <?php echo $carpool['departure_time']; ?></span>
    <span class="arrow">➜</span>
    <span><?php echo $carpool['arrival_city']; ?><br>
    <?php echo $carpool['arrival_time']; ?></span>
</div>

<div class="details">
    <span><?php echo $carpool['date'] ?></span>
    <span><em><?php echo $carpool['user_confirmed'] === 0 ? $carpool['status'] : ''; ?></em></span>
</div>