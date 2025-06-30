<?php

namespace App\Models;

// On hérite de la classe AbstractModel (qui gère la connexion et les méthodes communes)
use App\Models\AbstractModel;

class FormatsMatchsTypesMatchsModel extends AbstractModel 
{
    // Nom de la table associée à ce modèle
    protected string $table = 'formats_matchs_types_matchs';

    /**
     * Méthode pour récupérer tous les types de match associés à un format donné.
     *
     * @param int $formatId L'ID du format de match
     * @return array Liste des types de match liés à ce format
     */
    public function findByFormatId(int $formatId): array
    {
        // Connexion à la base de données
        $conn = $this->dbConnect();

        // Préparation de la requête SQL : on joint les tables pour avoir les noms des formats et types
        $stmt = $conn->prepare("
            SELECT 
                fm.id,                          -- ID de la ligne de liaison
                fm.match_type_id,              -- ID du type de match
                mf.name_type AS format_name,   -- Nom du format (ex: '1 vs 1', 'Tag Team'…)
                mt.name AS type_name           -- Nom du type de match (ex: 'No DQ', 'Steel Cage'…)
            FROM formats_matchs_types_matchs fm
            JOIN matchformats mf ON fm.matchformats_id = mf.id
            JOIN match_types mt ON fm.match_type_id = mt.id
            WHERE fm.matchformats_id = ?
        ");

        // Exécution de la requête avec l'ID du format
        $stmt->execute([$formatId]);

        // Retourne tous les résultats sous forme de tableau associatif
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}