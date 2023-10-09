<?php

declare(strict_types=1);

namespace App\Database;

use PDO;
use PDOException;

class DatabaseConnection
{
    private static ?self $instance = null;
    private PDO $dbConn;

    private function __construct(PDO $dbConn)
    {
        $this->dbConn = $dbConn;
    }

    public static function init(PDO $dbConn): self
    {
        return self::$instance ?? self::$instance = new self($dbConn);
    }

    public function connect(): PDO
    {
        return $this->dbConn;
    }

    public static function createConnection(array $config): ?self
    {
        try {
            $dbHost = filter_var($config['db_host'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $dbName = filter_var($config['db_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $dbUser = filter_var($config['db_user'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $dbPass = filter_var($config['db_pass'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if (empty($dbHost) || empty($dbName) || empty($dbUser) /*|| empty($dbPass)*/) {
                throw new \InvalidArgumentException('Invalid database configuration');
            }

            $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return self::init($pdo);
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
            return null;
        }
    }
}
