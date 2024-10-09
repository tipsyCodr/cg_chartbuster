-- 1. Artists Table
CREATE TABLE artists (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    bio TEXT,
    birth_date DATE,
    country VARCHAR(255),
    -- created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    -- updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
-- 2. Albums Table
CREATE TABLE albums (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    release_date DATE,
    genre VARCHAR(255),
    artist_id INT,
    -- created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    -- updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    -- FOREIGN KEY (artist_id) REFERENCES artists(id) ON DELETE
    SET NULL
);
-- 3. Movie_Artist Table (Many-to-Many)
-- Links movies to artists (since a movie can have multiple artists and an artist can work in multiple movies)
CREATE TABLE movie_artist (
    movie_id INT NOT NULL,
    artist_id INT NOT NULL,
    role VARCHAR(255),
    -- Role of the artist in the movie (e.g., actor, director, etc.)
    PRIMARY KEY (movie_id, artist_id),
    -- FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE,
    -- FOREIGN KEY (artist_id) REFERENCES artists(id) ON DELETE CASCADE
);
-- 4. Movie_Album Table (Many-to-Many)
-- Links movies to albums (since a movie can have multiple albums, such as soundtracks)
CREATE TABLE movie_album (
    movie_id INT NOT NULL,
    album_id INT NOT NULL,
    PRIMARY KEY (movie_id, album_id),
    -- FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE,
    -- FOREIGN KEY (album_id) REFERENCES albums(id) ON DELETE CASCADE
);