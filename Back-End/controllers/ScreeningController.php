<?php 

class ScreeningController {

    private PDO $conn;

    private function __construct(PDO $db) {
        $this->conn = $db; 
    }

    // get all movies (select all, CRUD Operation)
        public function getAllScreening(): void {
            $result = $this->conn->query("SELECT * FROM screenings");
            echo json_encode($result->fetchAll());
        }

    // create (CRUD Operation) -> POST (HTTP Method)
        public function createScreening(array $input): void {
            $stmt = $this->conn->prepare(
                "INSERT INTO screenings (movie_id, room_id, start_time)
                VALUES (?, ?, ?)"
            );
            $stmt->execute([
                $input['movie_id'],
                $input['room_id'],
                $input['start_time']
            ]);
            http_response_code(201); // created
            echo json_encode(["message" => "SCreening added yeay !!!"]);
        }

}


// $id
// movie_id
// room_id
// start_time