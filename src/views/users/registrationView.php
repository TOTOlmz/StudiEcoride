
<div class="form-container">
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
<div class="form-container">
    <div class="password-requirements">
        <p> Le mot de passe doit contenir au moins :</p>
        <span class="pass pass-length">8 caractères</span>
        <span class="pass pass-upper">Une majuscule</span>
        <span class="pass pass-lower">Une minuscule</span>
        <span class="pass pass-number">Un chiffre</span>
        <p id="passconf-label">Les mots de passe ne correspondent pas.</p>
    </div>
    
    <?php require_once __DIR__ . '/../checks.php' ?>

</div>

<script>
    // Validation du mot de passe côté client
    const form = document.querySelector('form');
    const password = document.getElementById('password');
    const passwordConfirm = document.getElementById('confirm-password');

    // Au chargement on cache les infos de validation
    document.querySelector('.password-requirements').style.display = 'none'; 
    document.querySelector('#passconf-label').style.display = 'none'; 

    document.querySelectorAll('.pass').forEach(item => {
        item.style.padding = '0.2rem 0.5rem';
        item.style.margin = '0.2rem';
        item.style.borderRadius = '5px';
        item.style.color = 'white';
        item.style.backgroundColor = '#a10000';
        item.style.display = 'inline-block';
    });

    password.addEventListener('input', checkForm);
    passwordConfirm.addEventListener('input', checkForm);

    function checkForm() {
        if (validatePassword()) {
            let confirmP = password.value === passwordConfirm.value;
            form.querySelector('button').disabled = confirmP ? false : true;
            document.querySelector('#passconf-label').style.display = 'block';
            document.querySelector('#passconf-label').style.color = confirmP ? '#196e44' : '#a10000';    
            document.querySelector('#passconf-label').textContent = confirmP ? 'Les mots de passe correspondent.' : 'Les mots de passe ne correspondent pas.'; 

        } 
    }

    function validatePassword(){
        document.querySelector('.password-requirements').style.display = 'block';
        let passValue = password.value;
        let validLength = passValue.length >= 8;
        let validUpper = passValue.toLowerCase() !== passValue;
        let validLower = passValue.toUpperCase() !== passValue;
        let validNumber = passValue.search(/[0-9]/) !== -1;
        document.querySelector('.pass-length').style.backgroundColor = validLength ? '#196e44' : '#a10000';
        document.querySelector('.pass-upper').style.backgroundColor = validUpper ? '#196e44' : '#a10000';
        document.querySelector('.pass-lower').style.backgroundColor = validLower ? '#196e44' : '#a10000';
        document.querySelector('.pass-number').style.backgroundColor = validNumber ? '#196e44' : '#a10000';
        return validLength && validUpper && validLower && validNumber;
    };
</script>