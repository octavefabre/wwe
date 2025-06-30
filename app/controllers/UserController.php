<?php

namespace App\Controllers;

use App\Controllers\AbstractController;
use App\Models\UserModel;
use App\Helpers\SessionManager;

class UserController extends AbstractController
{
    public function registerPost()
    {
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($username) || empty($password)) {
            echo "Tous les champs sont obligatoires.";
            return;
        }

        $userModel = new UserModel();

        if ($userModel->getUserByUsername($username)) {
            echo "Ce pseudo est déjà pris.";
            return;
        }

        if ($userModel->registerUser($username, $password)) {
            echo "Inscription réussie ! <a href='index.php?controller=user&action=loginForm'>Se connecter</a>";
        } else {
            echo "Erreur lors de l'inscription.";
        }
    }

    public function loginPost()
    {
        SessionManager::start();


        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            echo "Tous les champs sont obligatoires.";
            return;
        }

        $userModel = new UserModel();
        $user = $userModel->verifyUser($username, $password);

        if (!$user) {
            echo "Identifiants incorrects.";
            return;
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['pseudo'];

        echo "
            <script>
                alert('Connexion réussie !');
                window.location.href = 'index.php?controller=home&action=accueil';
            </script>
        ";
        exit();
    }
    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header('Location: index.php?controller=home&action=accueil');
        exit();
    }
}
