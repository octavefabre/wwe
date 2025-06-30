<div class="user-page-bg">
    <div class="register-form-container">
        <h1 class="register-title">INSCRIPTION</h1>
        
        <form class="register-form" method="POST" action="index.php?controller=user&action=registerPost">
            <div>
                <label for="username" class="register-label">Nom d'utilisateur :</label>
                <input type="text" id="username" name="username" class="register-input" required placeholder="Crée votre nom d'utilisateur">
            </div>

            <div>
                <label for="password" class="register-label">Mot de passe :</label>
                <input type="password" id="password" name="password" class="register-input" required placeholder="mot de passe">
            </div>

            <button type="submit" class="register-submit-btn">S'enregistrer</button>
        </form>
    </div>
</div> 