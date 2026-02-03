<?php

class MovieController { // it has to be class

    private PDO $conn;
 
    public function __construct(PDO $db) { // controller must receive PDO via constructor
        $this->conn = $db;
    }

    // get all movies (select all, CRUD Operation)
        public function getAllMovies(): void {
            $result = $this->conn->query("SELECT * FROM movies");
            echo json_encode($result->fetchAll());
        }

    // read (CRUD Operation) -> GET (HTTP Mzthod)
        public function readMovie(int $id): void {
            $stmt = $this->conn->prepare("SELECT * FROM movies WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode($stmt->fetch());
        }

    // create (CRUD Operation) -> POST (HTTP Method)
        public function createMovie(array $input): void {
            $stmt = $this->conn->prepare(
                "INSERT INTO movies (title, release_year, description, genre, director)
                VALUES (?, ?, ?, ?, ?)"
            );
            $stmt->execute([
                $input['title'],
                $input['release_year'],
                $input['description'] ?? null,
                $input['genre'] ?? null,
                $input['director'] ?? null
            ]);
            http_response_code(201); // Created
            echo json_encode(["message" => "Movie added yeay !!!"]);
        }

    // update (CRUD Operation) -> PUT/PATCH (HTTP Method)
        public function updateMovie(int $id, array $input): void {
            $stmt = $this->conn->prepare(
                "UPDATE movies
                SET title = ?, release_year = ?, description = ?, genre = ?, director = ?
                WHERE id = ?"
            );
            $stmt->execute([
                $input['title'],
                $input['release_year'],
                $input['description'] ?? null,
                $input['genre'] ?? null,
                $input['director'] ?? null,
                $id
            ]);
            http_response_code(200); // Success !!
            echo json_encode(["message" => "Movie updated yeay !!!"]);
        }

    // delete (CRUD Operation) -> DELETE (HTTP Method)
        public function deleteMovie(int $id): void {
            $stmt = $this->conn->prepare("DELETE FROM movies WHERE id = ?");
            $stmt->execute([$id]);
            http_response_code(200); // Success !!
            echo json_encode(["message" => "Movie deleted yeay !!!"]);
        }

}


// id
// title
// release_year
// description
// genre
// director