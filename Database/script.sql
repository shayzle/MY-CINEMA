CREATE DATABASE IF NOT EXISTS my_cinema;
USE my_cinema;



DROP TABLE IF EXISTS screenings;
DROP TABLE IF EXISTS rooms;
DROP TABLE IF EXISTS movies;



CREATE TABLE movies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    release_year INT NOT NULL,
    genre VARCHAR(100),
    director VARCHAR(100),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);



CREATE TABLE rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    capacity INT NOT NULL,
    type VARCHAR(100),
    active BOOLEAN NOT NULL DEFAULT TRUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);



CREATE TABLE screenings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    movie_id INT NOT NULL,
    room_id INT NOT NULL,
    start_time DATETIME NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_screenings_movie
        FOREIGN KEY (movie_id)
        REFERENCES movies(id)
        ON DELETE RESTRICT,

    CONSTRAINT fk_screenings_room
        FOREIGN KEY (room_id)
        REFERENCES rooms(id)
        ON DELETE RESTRICT
);




-- I'm INSERTING My "my_cinema" Data 

USE my_cinema;

INSERT INTO movies (title, release_year, genre, director)
VALUES
('Ponyo', 2008, 'Fantasy', 'Hayao Miyazaki'),
('Castle in the Sky', 1986, 'Adventure', 'Hayao Miyazaki'),
('My Neighbor Totoro', 1988, 'Fantasy', 'Hayao Miyazaki');

INSERT INTO rooms (name, capacity, type)
VALUES
('Room 1', 100, 'IMAX'),
('Room 2', 90, 'Normal'),
('Room 3', 80, '3D');

INSERT INTO screenings (movie_id, room_id, start_time)
VALUES
(1, 1, '2026-02-01 18:00:00'),
(2, 2, '2026-02-01 20:00:00'),
(3, 3, '2026-02-01 16:00:00');
 
SELECT
  movies.title,
  rooms.name AS room,
  screenings.start_time
FROM screenings
JOIN movies ON screenings.movie_id = movies.id
JOIN rooms ON screenings.room_id = rooms.id;
