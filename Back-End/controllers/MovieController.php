<?php

class movieController {

    private movieModel $model;

    public function __construct(PDO $pdo) {
        $this->model = new movieModel($pdo);
    }

    // GET /api/movies
    public function index(): void {
        echo json_encode($this->model->getAll());
    }

    // GET /api/movies/
    public function read(int $id): void {
        $movie = $this->model->getById($id);

        if (!$movie) {
            http_response_code(404);
            echo json_encode(['error' => 'Movie not found']);
            return;
        }

        echo json_encode($movie);
    }

    // POST /api/movies
    public function create(array $data): void {
        if (empty($data['title']) || empty($data['duration']) || empty($data['release_year'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Something is missing!!']);
            return;
        }

        $this->model->create($data);
        http_response_code(201);
        echo json_encode(['message' => 'Movie created']);
    }

    // PUT /api/movies
    public function update(int $id, array $data): void {
        if (empty($data['title']) || empty($data['duration']) || empty($data['release_year'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Something is missing!!']);
            return;
        }

        $this->model->update($id, $data);
        echo json_encode(['message' => 'Movie updated']);
    }

    // DELETE /api/movies
    public function delete(int $id): void {
        $this->model->delete($id);
        echo json_encode(['message' => 'Movie deleted']);
    }
}