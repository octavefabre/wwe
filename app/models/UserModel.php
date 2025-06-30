<?php

namespace App\Models;

use App\Models\AbstractModel;

class UserModel extends AbstractModel
{
    public function registerUser($username, $password)
    {
        $conn = $this->dbConnect();

        // Vérifie si l'utilisateur existe déjà
        if ($this->getUserByUsername($username)) {
            return false; // pseudo déjà pris
        }

        // Hash du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $request = "INSERT INTO `users` (`pseudo`, `password`) VALUES (:username, :password)";
        $stmt = $conn->prepare($request);
        return $stmt->execute([
            ':username' => $username,
            ':password' => $hashedPassword
        ]);
    }

    public function getUserByUsername($username)
    {
        $conn = $this->dbConnect();
        $request = "SELECT * FROM users WHERE pseudo = :username LIMIT 1";
        $stmt = $conn->prepare($request);
        $stmt->bindParam(':username', $username, \PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function verifyUser($username, $password)
    {
        $user = $this->getUserByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            return $user; // Connexion réussie
        }

        return false; // Échec de la connexion
    }
}
