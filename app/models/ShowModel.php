<?php

namespace App\Models;

use App\Models\AbstractModel;

class ShowModel extends AbstractModel
{
    public function findAllByName($showname)
    {
        $conn = $this->dbConnect();
        $query = "SELECT * FROM `shows` INNER JOIN `show_types` ON shows.show_type_id = show_types.id WHERE show_types.name = :showname";
        $statement = $conn->prepare($query);
        $statement->bindParam(':showname', $showname);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function findWithDetailsByType(string $type)
    {
        $db = $this->dbConnect();

        $sql = "
            SELECT 
                s.id AS show_id,
                s.name AS show_name,
                s.number AS show_number,
                st.name AS show_type_name,
                st.thumbnail AS show_thumbnail,
                m.id AS match_id,
                CONCAT(mf.name_type, ' - ', mt.name) AS match_type,
                t.name AS title_name,
                m.is_main_event,
                mp.team_number,
                mp.is_winner,
                w.name
            FROM shows s
            JOIN show_types st ON s.show_type_id = st.id
            JOIN matches m ON m.show_id = s.id
            JOIN formats_matchs_types_matchs fmtm ON m.formats_matchs_types_matchs_id = fmtm.id
            JOIN matchformats mf ON fmtm.matchformats_id = mf.id
            JOIN match_types mt ON fmtm.match_type_id = mt.id
            JOIN match_participants mp ON mp.match_id = m.id
            JOIN wrestlers w ON mp.wrestler_id = w.id
            LEFT JOIN titles t ON m.title_id = t.id
            WHERE st.name = :type
            ORDER BY s.number DESC, m.id;
        ";

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':type', $type);
        $stmt->execute();
        $rawResults = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $grouped = [];

        foreach ($rawResults as $row) {
            $key = $row['show_id'] . '_' . $row['match_id'];

            if (!isset($grouped[$key])) {
                $grouped[$key] = [
                    'show_id' => $row['show_id'],
                    'show_name' => $row['show_name'],
                    'show_number' => $row['show_number'],
                    'show_type_name' => $row['show_type_name'],
                    'show_thumbnail' => $row['show_thumbnail'],
                    'match_id' => $row['match_id'],
                    'match_type' => $row['match_type'],
                    'title_name' => $row['title_name'],
                    'is_main_event' => $row['is_main_event'],
                    'participants_full' => [],
                    'winners' => []
                ];
            }

            $grouped[$key]['participants_full'][] = [
                'name' => $row['name'],
                'team_number' => $row['team_number'],
                'is_winner' => $row['is_winner']
            ];

            if ($row['is_winner'] == 1) {
                $grouped[$key]['winners'][] = $row['name'];
            }
        }

        return array_values($grouped);
    }

    public function findPpvWithDetails()
    {
        return $this->findWithDetailsByType('Ppv');
    }
}
