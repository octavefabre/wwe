<?php

namespace App\Controllers;

// On utilise le contrôleur de base
use App\Controllers\AbstractController;
// On utilise le modèle utilisateur pour interagir avec la table `users`
use App\Models\UserModel;
// On utilise un gestionnaire de session (pour ouvrir la session proprement)
use App\Helpers\SessionManager;

class UserController extends AbstractController
{
    // Traitement du formulaire d'inscription (POST)
    public function registerPost()
    {
        // On récupère et nettoie les champs du formulaire
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        // Vérifie que les deux champs sont remplis
        if (empty($username) || empty($password)) {
            echo "Tous les champs sont obligatoires.";
            return;
        }

        $userModel = new UserModel();

        // Vérifie si un utilisateur existe déjà avec ce pseudo
        if ($userModel->getUserByUsername($username)) {
            echo "Ce pseudo est déjà pris.";
            return;
        }

        // Tente d'enregistrer l'utilisateur (avec mot de passe hashé)
        if ($userModel->registerUser($username, $password)) {
            echo "Inscription réussie ! <a href='index.php?controller=user&action=loginForm'>Se connecter</a>";
        } else {
            echo "Erreur lors de l'inscription.";
        }
    }

    // Traitement du formulaire de connexion (POST)
    public function loginPost()
    {
        // Démarre la session (si pas déjà démarrée)
        SessionManager::start();

        // Récupère les champs du formulaire
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        // Vérifie que les champs sont remplis
        if (empty($username) || empty($password)) {
            echo "Tous les champs sont obligatoires.";
            return;
        }

        $userModel = new UserModel();

        // Vérifie si les identifiants sont corrects (pseudo + mot de passe)
        $user = $userModel->verifyUser($username, $password);

        // Si l'utilisateur n'existe pas ou mot de passe invalide
        if (!$user) {
            echo "Identifiants incorrects.";
            return;
        }

        // Enregistrement des infos dans la session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['pseudo'];

        // Message JS et redirection vers l'accueil
        echo "
            <script>
                alert('Connexion réussie !');
                window.location.href = 'index.php?controller=home&action=accueil';
            </script>
        ";
        exit();
    }

    // Déconnexion de l'utilisateur
    public function logout()
    {
        // Démarre la session si elle n'est pas déjà démarrée
        session_start();

        // Supprime toutes les variables de session
        session_unset();

        // Détruit la session
        session_destroy();

        // Redirection vers la page d’accueil
        header('Location: index.php?controller=home&action=accueil');
        exit();
    }
}