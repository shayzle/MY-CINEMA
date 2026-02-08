<?php

class roomModel {

    private PDO $db;

    public function __construct(PDO $pdo) {
        $this->db = $pdo;
    }

    // GET all rooms
    public function getAll(): array {
        $stmt = $this->db->prepare("SELECT * FROM rooms");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // GET one room
    public function getById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM rooms WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    // CREATE room
    public function create(array $data): bool {
        $stmt = $this->db->prepare(
            "INSERT INTO rooms (name, capacity, type, active)
             VALUES (?, ?, ?, ?)"
        );

        return $stmt->execute([
            $data['name'],
            $data['capacity'],
            $data['type'] ?? null,
            $data['active'] ?? true
        ]);
    }

    // UPDATE room
    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare(
            "UPDATE rooms
             SET name = ?, capacity = ?, type = ?, active = ?
             WHERE id = ?"
        );

        return $stmt->execute([
            $data['name'],
            $data['capacity'],
            $data['type'] ?? null,
            $data['active'] ?? true,
            $id
        ]);
    }

    // DELETE room
    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM rooms WHERE id = ?");
        return $stmt->execute([$id]);
    }
}

// id
// name
// capacity
// type