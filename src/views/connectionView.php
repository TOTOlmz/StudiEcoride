
<div class="form-container">
    <h2>Connexion</h2>
    <form method="post" action="">
        <div class="form-group">
            <input type="email" id="email" name="email" placeholder="Email" required>
        </div>
        <div class="form-group">
            <input type="password" id="password" name="password" placeholder="Mot de passe" required>
        </div>
        <button type="submit">Se connecter</button>
    </form>

    <div>
        <?php if (!empty($errors)): ?>
            <div class="errors">
                <?php foreach ($errors as $error): ?>
                    <p style="color:red"><?php echo htmlspecialchars($error) ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($success)): ?>
            <?php if ($_SESSION['user_role'] === 'USER'): ?>
                <p style="color:green"><?php echo htmlspecialchars($success) ?> 
                <a href="./mon-espace">Accéder à mon espace</a></p>
            <?php elseif ($_SESSION['user_role'] === 'STAFF'): ?>
                <p style="color:green"><?php echo htmlspecialchars($success) ?> 
                <a href="./staff-espace">Accéder à mon espace employé</a></p>
            <?php elseif ($_SESSION['user_role'] === 'ADMIN'): ?>
                <p style="color:green"><?php echo htmlspecialchars($success) ?> 
                <a href="./admin-espace">Accéder à mon espace administrateur</a></p>;
            <?php endif; ?>
        <?php else: ?>
            <p>Pas encore de compte ?</p>
            <a href="./inscription">Créer un compte</a>
        <?php endif; ?>
    </div>
</div>