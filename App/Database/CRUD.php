<?php

declare(strict_types=1);

namespace App\Database;

use PDO;
use PDOException;

class CRUD
{
    private DatabaseConnection $dbConnection;

    public function __construct(DatabaseConnection $dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    public function create(string $table, array $data): bool
    {
        try {
            $columns = implode(', ', array_keys($data));
            $values = ':' . implode(', :', array_keys($data));

            $query = "INSERT INTO $table ($columns) VALUES ($values)";

            $pdo = $this->dbConnection->connect();
            $statement = $pdo->prepare($query);

            foreach ($data as $key => $value) {
                $statement->bindValue(":$key", $value);
            }

            return $statement->execute();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    public function read(string $table, array $conditions = []): array
    {
        try {
            $query = "SELECT * FROM $table";

            if (!empty($conditions)) {
                $query .= ' WHERE ';
                $query .= implode(' AND ', $conditions);
            }

            $pdo = $this->dbConnection->connect();
            $statement = $pdo->query($query);

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return [];
        }
    }

    public function update(string $table, array $data, array $conditions = []): bool
    {
        try {
            $setClauses = [];
            foreach ($data as $key => $value) {
                $setClauses[] = "$key = :$key";
            }
            $setClause = implode(', ', $setClauses);

            $query = "UPDATE $table SET $setClause";

            if (!empty($conditions)) {
                $query .= ' WHERE ';
                $query .= implode(' AND ', $conditions);
            }

            $pdo = $this->dbConnection->connect();
            $statement = $pdo->prepare($query);

            foreach ($data as $key => $value) {
                $statement->bindValue(":$key", $value);
            }

            return $statement->execute();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    public function delete(string $table, array $conditions = []): bool
    {
        try {
            $query = "DELETE FROM $table";

            if (!empty($conditions)) {
                $query .= ' WHERE ';
                $query .= implode(' AND ', $conditions);
            }

            $pdo = $this->dbConnection->connect();
            $statement = $pdo->prepare($query);

            return $statement->execute();
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    public function search(string $table, array $conditions): array
    {
        // This method allows you to search for records in a table based on specific criteria.
        // Example usage: $crud->search('users', ['name LIKE :name', 'age > :age'], [':name' => 'John%', ':age' => 30]);

        try {
            $query = "SELECT * FROM $table";

            if (!empty($conditions)) {
                $query .= ' WHERE ';
                $query .= implode(' AND ', $conditions);
            }

            $pdo = $this->dbConnection->connect();
            $statement = $pdo->prepare($query);

            foreach ($conditions as $param => $value) {
                $statement->bindValue($param, $value);
            }

            $statement->execute();

            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return [];
        }
    }
}
