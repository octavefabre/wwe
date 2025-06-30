<?php

namespace App\Models;

// On utilise le modèle de base (classe abstraite) pour se connecter à la BDD
use App\Models\AbstractModel;

class MatchTypeModel extends AbstractModel
{
    // Nom de la table dans la base de données
    protected string $table = "match_types";

    /**
     * Méthode pour récupérer tous les types de match liés à un format de match spécifique.
     *
     * @param int $matchformats_id L’ID du format de match
     * @return array Une liste des types de match associés
     */
    public function findByFormatId(int $matchformats_id): array
    {
        // Connexion à la base de données (via la méthode héritée)
        $conn = $this->dbConnect();

        // Requête SQL : on sélectionne tous les types de match liés au format donné
        $query = "SELECT mt.*
                  FROM match_types mt
                  INNER JOIN formats_matchs_types_matchs fmtm ON mt.id = fmtm.match_type_id
                  WHERE fmtm.matchformats_id = :matchformats_id";

        // Préparation de la requête pour éviter les injections SQL
        $statement = $conn->prepare($query);

        // On lie l'ID du format au paramètre de la requête
        $statement->bindValue(':matchformats_id', $matchformats_id, \PDO::PARAM_INT);

        // Exécution de la requête
        $statement->execute();

        // On retourne tous les résultats trouvés sous forme de tableau associatif
        return $statement->fetchAll();
    }
}