<?php

class screeningController {

    private screeningModel $model;

    public function __construct(PDO $pdo) {
        $this->model = new screeningModel($pdo);
    }

    // GET /api/screenings
    public function index(): void {
        echo json_encode($this->model->getAll());
    }

    // GET /api/screenings/{id}
    public function read(int $id): void {
        $screening = $this->model->getById($id);

        if (!$screening) {
            http_response_code(404);
            echo json_encode(['error' => 'Screening not found']);
            return;
        }

        echo json_encode($screening);
    }

    // POST /api/screenings
    public function create(array $data): void {
        if (empty($data['movie_id']) || empty($data['room_id']) || empty($data['start_time'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Something is missing!!']);
            return;
        }

        $this->model->create($data);
        http_response_code(201);
        echo json_encode(['message' => 'Screening created']);
    }

    // PUT /api/screenings/{id}
    public function update(int $id, array $data): void {
        if (empty($data['movie_id']) || empty($data['room_id']) || empty($data['start_time'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Something is missing!!']);
            return;
        }

        $this->model->update($id, $data);
        echo json_encode(['message' => 'Screening updated']);
    }

    // DELETE /api/screenings/{id}
    public function delete(int $id): void {
        $this->model->delete($id);
        echo json_encode(['message' => 'Screening deleted']);
    }
}

// $id
// movie_id
// room_id
// start_time