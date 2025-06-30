<?php

namespace App\Models;

use App\Models\AbstractModel;

class MatchTypeModel extends AbstractModel
{
    protected string $table = "match_types";

    /**
     * Récupère tous les types de match associés à un format de match donné.
     *
     * @param int $matchformats_id ID du format de match
     * @return array Liste des types de match associés
     */
    public function findByFormatId(int $matchformats_id): array
    {
        $conn = $this->dbConnect();

        $query = "SELECT mt.*
                  FROM match_types mt
                  INNER JOIN formats_matchs_types_matchs fmtm ON mt.id = fmtm.match_type_id
                  WHERE fmtm.matchformats_id = :matchformats_id";

        $statement = $conn->prepare($query);
        $statement->bindValue(':matchformats_id', $matchformats_id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }
}