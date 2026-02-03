<?php 

class RoomModel {

    // Room properties
    public ?int $id;
    public string $name;
    public int $capacity;
    public ?string $type;
    public bool $active;

    // Constructor
    public function __construct(
        ?int $id,
        string $name,
        int $capacity,
        ?string $type = null,
        bool $active = true
    ) {
    // initialize properties
        $this->id = $id;
        $this->name = $name;
        $this->capacity = $capacity;
        $this->type = $type;
        $this->active = $active;
    }

    public static function fromArray(array $data): Room {
            // factory method to create a Room instance from an associative array
        return new Room(
            $data['id'] ?? null,
            $data['name'],
            $data['capacity'],
            $data['type'] ?? null,
            (bool) ($data['active'] ?? true)
        );
    }
}
