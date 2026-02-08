<?php

class roomController {

    private roomModel $model;

    public function __construct(PDO $pdo) {
        $this->model = new roomModel($pdo);
    }

    // GET /api/rooms
    public function index(): void {
        echo json_encode($this->model->getAll());
    }

    // GET /api/rooms/{id}
    public function read(int $id): void {
        $room = $this->model->getById($id);

        if (!$room) {
            http_response_code(404);
            echo json_encode(['error' => 'Room not found']);
            return;
        }

        echo json_encode($room);
    }

    // POST /api/rooms
    public function create(array $data): void {
        if (empty($data['name']) || empty($data['capacity'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Something is missing!!']);
            return;
        }

        $this->model->create($data);
        http_response_code(201);
        echo json_encode(['message' => 'Room created']);
    }

    // PUT /api/rooms/{id}
    public function update(int $id, array $data): void {
        if (empty($data['name']) || empty($data['capacity'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Something is missing!!']);
            return;
        }

        $this->model->update($id, $data);
        echo json_encode(['message' => 'Room updated']);
    }

    // DELETE /api/rooms/{id}
    public function delete(int $id): void {
        $this->model->delete($id);
        echo json_encode(['message' => 'Room deleted']);
    }
}

// id
// name
// capacity
// type