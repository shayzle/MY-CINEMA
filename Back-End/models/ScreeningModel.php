<?php

class ScreeningModel {

    // Screening properties
    public ?int $id;
    public int $movie_id;
    public int $room_id;
    public string $start_time;

    // Constructor
    public function __construct(
        ?int $id,
        int $movie_id,
        int $room_id,
        string $start_time
    ) {
        // initialize properties
        $this->id = $id;
        $this->movie_id = $movie_id;
        $this->room_id = $room_id;
        $this->start_time = $start_time;
    }

    public static function fromArray(array $data): Screening {
        // factory method to create a screening instance from an associative array
        return new Screening(
            $data['id'] ?? null,
            $data['movie_id'],
            $data['room_id'],
            $data['start_time']
        );
    }
}
