<div class="log-container">
    <h2>Créer un compte</h2>
    <form method="post" action="">
        <div class="form-group">
            <input type="text" id="pseudo" name="pseudo" placeholder="Pseudo" required>
        </div>
        <div class="form-group">
            <input type="email" id="email" name="email" placeholder="email" required>
        </div>
        <div class="form-group">
            <input type="password" id="password" name="password" placeholder="mot de passe" required>
        </div>
        <div class="form-group">
            <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirmation du mot de passe" required>
        </div>
        <button type="submit" disabled>S'inscrire</button>        
    </form>
    <div>
        <p> Déjà un compte ? <a href="./connexion">cliquez ici</a></p>
    </div>
</div>

<div>
    <p id="passconf-label" style="opacity:0;">Les mots de passe ne correspondent pas.</p>
    <div class="password-requirements" style="opacity:0;">
        <p> Le mot de passe doit contenir au moins :</p>
        <span>8 caractères : </span><span class="pass pass-length">✖</span>
        <span>Une majuscule : </span><span class="pass pass-upper">✖</span>
        <span>Une minuscule : </span><span class="pass pass-lower">✖</span>
        <span>Un chiffre :  </span><span class="pass pass-number">✖</span>
    </div>
    <?php if (!empty($errors)): ?>
        <div class="errors">
            <?php foreach ($errors as $error): ?>
                <p style="color:red"><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <?php if (!empty($success)): ?>
        <p style="color:green"><?= htmlspecialchars($success) ?> 
           <a href="./mon-espace">Accéder à mon espace</a>
        </p>
    <?php endif; ?>
</div>

<script>
    // Validation du mot de passe côté client
    const form = document.querySelector('form');
    const password = document.getElementById('password');
    const passwordConfirm = document.getElementById('confirm-password');

    password.addEventListener('input', checkForm);
    passwordConfirm.addEventListener('input', checkForm);

    function checkForm() {
        if (validatePassword()) {
            let confirmP = password.value === passwordConfirm.value;
            form.querySelector('button').disabled = confirmP ? false : true;
            form.querySelector('#passconf-label').style.opacity = 1;
            form.querySelector('#passconf-label').style.color = confirmP ? 'green' : 'red';    
            form.querySelector('#passconf-label').textContent = confirmP ? 'Les mots de passe correspondent.' : 'Les mots de passe ne correspondent pas.'; 
        } 
    }

    function validatePassword(){
        document.querySelector('.password-requirements').style.opacity = 1;
        let passValue = password.value;
        let validLength = passValue.length >= 8;
        let validUpper = passValue.toLowerCase() !== passValue;
        let validLower = passValue.toUpperCase() !== passValue;
        let validNumber = passValue.search(/[0-9]/) !== -1;
        document.querySelector('.pass-length').textContent = validLength ? '✔' : '✖';
        document.querySelector('.pass-upper').textContent = validUpper ? '✔' : '✖';
        document.querySelector('.pass-lower').textContent = validLower ? '✔' : '✖';
        document.querySelector('.pass-number').textContent = validNumber ? '✔' : '✖';
        document.querySelector('.pass-length').style.color = validLength ? 'green' : 'red';
        document.querySelector('.pass-upper').style.color = validUpper ? 'green' : 'red';
        document.querySelector('.pass-lower').style.color = validLower ? 'green' : 'red';
        document.querySelector('.pass-number').style.color = validNumber ? 'green' : 'red';
        return validLength && validUpper && validLower && validNumber;
    };
</script>