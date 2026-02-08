<?php

class screeningModel {

    private PDO $db;

    public function __construct(PDO $pdo) {
        $this->db = $pdo;
    }

    // GET all screenings
    public function getAll(): array {
        $stmt = $this->db->prepare("SELECT * FROM screenings");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // GET one screening
    public function getById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM screenings WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    // CREATE screening
    public function create(array $data): bool {
        $stmt = $this->db->prepare(
            "INSERT INTO screenings (movie_id, room_id, start_time)
             VALUES (?, ?, ?)"
        );

        return $stmt->execute([
            $data['movie_id'],
            $data['room_id'],
            $data['start_time']
        ]);
    }

    // UPDATE screening
    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare(
            "UPDATE screenings
             SET movie_id = ?, room_id = ?, start_time = ?
             WHERE id = ?"
        );

        return $stmt->execute([
            $data['movie_id'],
            $data['room_id'],
            $data['start_time'],
            $id
        ]);
    }

    // DELETE screening
    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM screenings WHERE id = ?");
        return $stmt->execute([$id]);
    }
}

// $id
// movie_id
// room_id
// start_time