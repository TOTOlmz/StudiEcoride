

<div class="staff-panel">
    <h2>Gestion des comptes employé</h2>
    <button class="button creat-form-call">Créer un compte employé</button>
    <button class="button suspend-form-call">Suspendre / Réactiver un compte</button>
</div>

<div class="security-area" id="create-account" hidden>
    <div class="form-container">
        <h2>Créer un compte employé</h2>
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
                <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirmez le mot de passe" required>
            </div>
            <button type="submit" name="account-creation">Créer le compte</button>        
        </form>

        <div class="messsage-box"></div>
    </div>

    
</div>

<div class="security-area" id="suspend-account" hidden>
    <div class="form-container">
        <h2>Renseignez l'identifiant du compte à suspendre / réactiver</h2>
        <form method="post" action="">
            <div class="form-group">
                <input type="number" id="user-id" name="user-id" placeholder="Identifiant du compte" required>
            </div>
            <button type="submit" name="suspend-account">suspendre / réactiver</button>        
        </form>

        <div class="messsage-box"></div>
    </div>
</div>


<script>

    // Pour une gestion des comptes un peu sympa
    const createAccount = document.getElementById('create-account');
    const creationBtn = document.querySelector('.creat-form-call');
    
    const suspendAccount = document.getElementById('suspend-account');
    const suspensionBtn = document.querySelector('.suspend-form-call');

    creationBtn.addEventListener('click', () => {
            createAccount.hidden = false;
    });
    suspensionBtn.addEventListener('click', () => {
            suspendAccount.hidden = false;
    });

    createAccount.addEventListener('click', (e) => {
        if(e.target === createAccount){
            createAccount.hidden = true;
        }
    });

    suspendAccount.addEventListener('click', (e) => {
        if(e.target === suspendAccount){
            suspendAccount.hidden = true;
        }
    });

</script>