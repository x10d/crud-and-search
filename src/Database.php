<?php

namespace App;

use PDO;
use PDOException;

class Database
{
    private $pdo;

    public function __construct($credentials)
    {
        $dsn = "mysql:host={$credentials['host']};dbname={$credentials['database']}";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $credentials['username'], $credentials['password'], $options);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    // Dodaj getter do uzyskiwania obiektu PDO
    public function getPdo()
    {
        return $this->pdo;
    }
}
