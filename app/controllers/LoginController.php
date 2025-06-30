<?php

namespace App\Controllers;

use App\Controllers\AbstractController;

class LoginController extends AbstractController




{
    public function login()
{
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $userModel = new \App\Models\UserModel();
        $user = $userModel->verifyUser($username, $password);

        if ($user) {
            $_SESSION['pseudo'] = $user['pseudo'];
            header('Location: index.php?controller=home&action=accueil');
            exit();
        } else {
            $erreur = "Identifiants incorrects.";
            return $this->render("login.php", ['erreur' => $erreur]);
        }
    }

    header('Location: index.php?controller=login&action=loginpage');
    exit();
}
    public function loginpage()
    {
        return $this->render("login.php");
    }
}