<?php

namespace App\Models;

// On utilise le modèle de base pour avoir accès à la connexion BDD
use App\Models\AbstractModel;

class UserModel extends AbstractModel
{
    /**
     * Enregistre un nouvel utilisateur en base de données.
     *
     * @param string $username Le pseudo de l’utilisateur
     * @param string $password Le mot de passe (en clair, sera hashé)
     * @return bool Retourne true si inscription réussie, false si le pseudo existe déjà
     */
    public function registerUser($username, $password)
    {
        // Connexion à la base de données
        $conn = $this->dbConnect();

        // Vérifie si un utilisateur avec ce pseudo existe déjà
        if ($this->getUserByUsername($username)) {
            return false; // Pseudo déjà utilisé
        }

        // On hash le mot de passe pour le sécuriser
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Requête pour insérer le nouvel utilisateur
        $request = "INSERT INTO `users` (`pseudo`, `password`) VALUES (:username, :password)";
        $stmt = $conn->prepare($request);

        // Exécute la requête avec les valeurs
        return $stmt->execute([
            ':username' => $username,
            ':password' => $hashedPassword
        ]);
    }

    /**
     * Récupère un utilisateur à partir de son pseudo.
     *
     * @param string $username Le pseudo à chercher
     * @return array|null Les données de l'utilisateur ou null s'il n'existe pas
     */
    public function getUserByUsername($username)
    {
        // Connexion à la BDD
        $conn = $this->dbConnect();

        // Requête pour chercher l’utilisateur
        $request = "SELECT * FROM users WHERE pseudo = :username LIMIT 1";
        $stmt = $conn->prepare($request);
        $stmt->bindParam(':username', $username, \PDO::PARAM_STR);
        $stmt->execute();

        // Retourne l'utilisateur s'il existe (ou false/null si rien trouvé)
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Vérifie si les identifiants (pseudo + mot de passe) sont valides.
     *
     * @param string $username Le pseudo
     * @param string $password Le mot de passe (en clair)
     * @return array|false Retourne les infos de l'utilisateur si ok, sinon false
     */
    public function verifyUser($username, $password)
    {
        // Récupère l'utilisateur via le pseudo
        $user = $this->getUserByUsername($username);

        // Vérifie le mot de passe (comparaison avec le hash)
        if ($user && password_verify($password, $user['password'])) {
            return $user; // Connexion réussie
        }

        return false; // Connexion échouée
    }
}