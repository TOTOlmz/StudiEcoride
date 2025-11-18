
<div class="security-area" id="popup-book">
    <div class="form-container">
        <h3>Réserver des sièges</h3>
        <form id="booking-form" method="POST" action="./confirmation-de-reservation?c=<?php echo $carpool['id']; ?>">
            <label for="seats">Nombre de sièges :</label>
            <input type="number" id="seats" name="seats" min="1" max="<?php echo intval($carpool['available_seats']); ?>" value="1">
            <input type="number" id="price" name="price" value="<?php echo intval($carpool['price']); ?>" hidden>
            <input type="number" id="user-id" name="user-id" value="<?php echo $user['id']; ?>" hidden>
            <p id="total-price"></p>
            <button type="submit" id="confirm-book">Confirmer</button>
        </form>
        <button id="close-popup">Annuler</button>
    </div>
</div>

<div id="popup-overlay"></div>

<div class="action-btn">
    <?php if (!isset($_SESSION['user_id'])): ?>
        <p>Connectez vous pour réserver</p>
        <a href="./connexion">Connexion</a>
    <?php else: ?>
        <a id="book" href="">Réserver</a>
    <?php endif; ?>
</div>

<script>
    const bookBtn = document.getElementById('book');
    const popup = document.getElementById('popup-book');
    const overlay = document.getElementById('popup-overlay');
    const seatsInput = document.getElementById('seats');
    const totalPrice = document.getElementById('total-price');
    const pricePerSeat = <?php echo floatval($carpool['price']); ?>;
    const userCredits = <?php echo intval($user['credits']); ?>;
    const confirmBookBtn = document.getElementById('confirm-book');

    popup.hidden = true;

    function updatePrice() {
        const seats = parseInt(seatsInput.value) || 1;
        if(seats * pricePerSeat > userCredits) {
            totalPrice.textContent = "Credits insuffisants.";
            confirmBookBtn.disabled = true;
        }else{
        totalPrice.textContent = "Montant total : " + (seats * pricePerSeat) + " crédits";
        confirmBookBtn.disabled = false;
        }
    }

    if (bookBtn) {
        bookBtn.addEventListener('click', function(e) {
            e.preventDefault();
            popup.style.display = 'block';
            overlay.style.display = 'block';
            updatePrice();
        });
    }

    seatsInput.addEventListener('input', updatePrice);

    document.getElementById('close-popup').onclick = function() {
        popup.style.display = 'none';
        overlay.style.display = 'none';
    };

    overlay.onclick = function() {
        popup.style.display = 'none';
        overlay.style.display = 'none';
    };
</script>