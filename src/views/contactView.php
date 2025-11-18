


<div class="center-container">
    <h2>Contact</h2>
    <form class="form-container" method="post" action="">
        <div class="form-group">
            <input type="email" id="email" name="email" placeholder="Votre email" required>
        </div>
        <div class="form-group">
            <input type="text" id="name" name="name" placeholder="Votre nom" required>
        </div>
        <div class="form-group">
            <input type="text" id="subject" name="subject" placeholder="Objet" required>
        </div>
        <div class="form-group">
            <textarea id="message" name="message" placeholder="Votre message" required></textarea>
        </div>
        <button type="submit" name="contact-form">Laisser un message</button>

        
        <?php include 'checks.php'; ?>
    </form>

</div>