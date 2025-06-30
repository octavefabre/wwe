<?php

namespace App\Models;

abstract class AbstractModel {

    protected array $attributes = [];

    public function __get(string $name) {
        return $this->attributes[$name] ?? null;
    }

    public function __set(string $name, $value): void {
        $this->attributes[$name] = $value;
    }

    public function findAll(): array {
        $conn = $this->dbConnect();
        $query = "SELECT * FROM " . $this->getTable();
        $statement = $conn->prepare($query);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function find(int $id): ?object {
        $conn = $this->dbConnect();
        $query = "SELECT * FROM " . $this->getTable() . " WHERE id = :id";
        $statement = $conn->prepare($query);
        $statement->bindParam(":id", $id);
        $statement->execute();

        $result = $statement->fetch();

        if ($result === false) {
            return null;
        }

        $this->attributes = $result;

        return $this;
    }

    public function insert(): void {
        $conn = $this->dbConnect();

        $columns = [];
        $placeholders = [];
        $bindValues = [];

        foreach ($this->attributes as $key => $value) {
            if ($key === 'id') continue;
            $columns[] = $key;
            $placeholders[] = ':' . $key;
            $bindValues[':' . $key] = $value;
        }

        $columnsStr = implode(', ', $columns);
        $placeholdersStr = implode(', ', $placeholders);

        $query = "INSERT INTO " . $this->getTable() . " ($columnsStr) VALUES ($placeholdersStr)";

        $statement = $conn->prepare($query);

        foreach ($bindValues as $placeholder => $value) {
            $statement->bindValue($placeholder, $value);
        }

        $statement->execute();
    }

    public function delete(int $id): bool {
        $conn = $this->dbConnect();
        $query = "DELETE FROM " . $this->getTable() . " WHERE id = :id";
        $statement = $conn->prepare($query);
        $statement->bindParam(":id", $id);
        $statement->execute();

        return $statement->rowCount() > 0;
    }

    public function deleteAll(): bool {
        $conn = $this->dbConnect();
        $query = "DELETE FROM " . $this->getTable();
        $statement = $conn->prepare($query);
        $statement->execute();

        return $statement->rowCount() > 0;
    }

    protected function dbConnect(): \PDO {
        $config = json_decode(file_get_contents(ROOT_DIR . '/config.json'), true)['db'];

        try {
            $conn = new \PDO(
                "mysql:host={$config['host']};dbname={$config['name']}",
                $config['user'],
                $config['passwd'],
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                    \PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );

            return $conn;
        } catch (\PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    protected function getTable(): string {
        if (property_exists($this, 'table')) {
            return $this->table;
        }
        $loadedClass = new \ReflectionClass($this);
        return strtolower(str_replace("Model", "", $loadedClass->getShortName())) . "s";
    }
}