<?php

class MovieModel {

    // Movie properties
    public ?int $id;
    public string $title;
    public int $release_year;
    public ?string $description;
    public ?string $genre;
    public ?string $director;

    // Constructor 
    public function __construct(
        ?int $id,
        string $title,
        int $release_year,
        ?string $description = null,
        ?string $genre = null,
        ?string $director = null
    ) {
        // initialize properties
        $this->id = $id;
        $this->title = $title;
        $this->release_year = $release_year;
        $this->description = $description;
        $this->genre = $genre;
        $this->director = $director;
    }

    
    public static function fromArray(array $data): Movie {
            // factory method to create a Movie instance from an associative array
        return new Movie(
            $data['id'] ?? null,
            $data['title'],
            $data['release_year'],
            $data['description'] ?? null,
            $data['genre'] ?? null,
            $data['director'] ?? null
        );
    }
}
