<?php

class movieModel {

    private PDO $db;

    public function __construct(PDO $pdo) {
        $this->db = $pdo;
    }

    // GET all movies
    public function getAll(): array {
        $stmt = $this->db->prepare("SELECT * FROM movies");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // GET one movie
    public function getById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM movies WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch() ?: null;
    }

    // CREATE movie
    public function create(array $data): bool {
        $stmt = $this->db->prepare(
            "INSERT INTO movies (title, duration, release_year, description, genre, director)
             VALUES (?, ?, ?, ?, ?, ?)"
        );

        return $stmt->execute([
            $data['title'],
            $data['duration'],
            $data['release_year'],
            $data['description'] ?? null,
            $data['genre'] ?? null,
            $data['director'] ?? null
        ]);
    }

    // UPDATE movie
    public function update(int $id, array $data): bool {
        $stmt = $this->db->prepare(
            "UPDATE movies
             SET title = ?, duration = ?, release_year = ?, description = ?, genre = ?, director = ?
             WHERE id = ?"
        );

        return $stmt->execute([
            $data['title'],
            $data['duration'],
            $data['release_year'],
            $data['description'] ?? null,
            $data['genre'] ?? null,
            $data['director'] ?? null,
            $id
        ]);
    }

    // DELETE movie
    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM movies WHERE id = ?");
        return $stmt->execute([$id]);
    }
}

// id
// title
// release_year
// description
// genre
// director