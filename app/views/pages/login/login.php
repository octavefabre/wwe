<div class="user-page-bg">
    <div class="wsm-login-container">
        <h2 class="wsm-login-title">Connexion</h2>
        
        <form class="wsm-login-form" method="POST" action="index.php?controller=user&action=loginPost">
            <div>
                <label for="username" class="wsm-login-label">Nom d'utilisateur :</label>
                <input type="text" id="username" name="username" class="wsm-login-input" required placeholder="Entrez votre nom d'utilisateur">
            </div>

            <div>
                <label for="password" class="wsm-login-label">Mot de passe :</label>
                <input type="password" id="password" name="password" class="wsm-login-input" required placeholder="Votre mot de passe">
            </div>

            <button type="submit" class="wsm-login-btn">Se connecter</button>
        </form>

        <div class="wsm-login-footer">
            <p>Pas encore inscrit ? <a href="index.php?controller=register&action=registerpage" class="wsm-login-link">Créer un compte</a></p>
        </div>
    </div>
</div>