<?php

namespace App\Models;

use App\Models\AbstractModel;


class TitleModel extends AbstractModel
{
    public function findAll(): array
    {
        $conn = $this->dbConnect();
        $query = "SELECT * FROM titles";
        $statement = $conn->prepare($query);
        $statement->execute();
        return $statement->fetchAll(); // Retourne un tableau, comme attendu
    }

    public function find(int $id): ?object
    {
        $conn = $this->dbConnect();
        $query = "SELECT * FROM titles WHERE id = :id";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $result = $stmt->fetch();

        if (!$result) {
            return null;
        }

        $this->attributes = $result;

        return $this;
    }
}
