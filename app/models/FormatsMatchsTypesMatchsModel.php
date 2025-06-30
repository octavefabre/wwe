<?php

namespace App\Models;

use App\Models\AbstractModel;

class FormatsMatchsTypesMatchsModel extends AbstractModel 
{
    protected string $table = 'formats_matchs_types_matchs';
    public function findByFormatId(int $formatId): array
    {
        $conn = $this->dbConnect();

        $stmt = $conn->prepare("
    SELECT 
        fm.id,
        fm.match_type_id,
        mf.name_type AS format_name,
        mt.name AS type_name
    FROM formats_matchs_types_matchs fm
    JOIN matchformats mf ON fm.matchformats_id = mf.id
    JOIN match_types mt ON fm.match_type_id = mt.id
    WHERE fm.matchformats_id = ?
");
        $stmt->execute([$formatId]);

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
