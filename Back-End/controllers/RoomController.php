<?php 

class RoomController {

    private PDO $conn;

    public function __construct(PDO $db) {
        $this->conn = $db; // controller must receive PDO via constructor
    }

    // get all rooms (select all, CRUD Operation)
        public function getAllRooms(): void {
            $result = $this->conn->query("Select * FROM rooms");
            echo json_encode($result->fetchAll());
        }

    // create (CRUD Operation) -> POST (HTTP Method)
        public function createRoom(array $input): void {
            $stmt = $this->conn->prepare(
                "INSERT INTO rooms (name, capacity, type, active)
                VALUES (?, ?, ?, ?)"
            );
            $stmt->execute([
                $input['name'],
                $input['capacity'],
                $input['type'] ?? null,
                $input['active'] ?? true
            ]);
            http_response_code(201); // CReated
            echo json_encode(["message" => "Room added successfully!"]);
        }

}
    

    // id
    // name
    // capacity
    // type