<?php

namespace App;

class Entry
{
    private $pdo;

    public $id;
    public $name;
    public $status;
    public $createdAt;

    public function __construct(Database $database)
    {
        $this->pdo = $database->getPdo();
    }

    public function createEntry($name, $status)
    {
        $createdAt = date('Y-m-d H:i:s');
        $sql = "INSERT INTO entries (name, status, created_at) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$name, $status, $createdAt]);

        $entryId = $this->pdo->lastInsertId();
        $this->addStatusToHistory($entryId, $status, $createdAt);
    }

    public function getEntryById($id)
    {
        $sql = "SELECT * FROM entries WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function updateStatus($id, $status)
    {
        $sql = "UPDATE entries SET status = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$status, $id]);
        $createdAt = date('Y-m-d H:i:s');
        $this->addStatusToHistory($id, $status, $createdAt);
    }

    public function deleteEntry($id)
    {
        $sql = "DELETE FROM entries WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
    }

    public function searchByName($name)
    {
        $sql = "SELECT * FROM entries WHERE name LIKE ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(["%$name%"]);
        return $stmt->fetchAll();
    }

    public function searchByCurrentStatus($status)
    {
        $sql = "SELECT * FROM entries WHERE status = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$status]);
        return $stmt->fetchAll();
    }

    public function searchByHistoryStatus($status)
    {
        $sql = "SELECT e.id, e.name, e.status as current_status, sh.status as historical_status, sh.created_at
            FROM entries e
            JOIN status_history sh ON e.id = sh.entry_id
            WHERE sh.status = ?
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$status]);
        return $stmt->fetchAll();
    }

    private function addStatusToHistory($entryId, $status, $createdAt)
    {
        $sql = "INSERT INTO status_history (entry_id, status, created_at) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$entryId, $status, $createdAt]);
    }
}
