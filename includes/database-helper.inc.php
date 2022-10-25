<?php

class DatabaseHelper{
    public static function createConnection($conn, $username, $password){
        $pdo = new PDO($conn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    public static function runQuery($pdo, $sql, $value, $replace){
        //used for when user input is involved and has no limitations
        //only does basic prevention
        $statement = $pdo->prepare($sql);
        $statement -> bindValue($replace, $value, PDO::PARAM_STR);
        $statement -> execute();
        return $statement;
    }

    public static function runBasicQuery($pdo, $sql){
        //used for when user input is not involved
        $statement = $pdo->prepare($sql);
        $statement -> execute();
        return $statement;
    }
}

class SongDB{

    private static $sqlSearch = "SELECT title, artist_name as name, type_name as type, genre_name as genre, year, SEC_TO_TIME(duration) as duration, bpm, energy, danceability, liveness, valence, acousticness, speechiness, popularity, songs.artist_id, artist_type_id, songs.genre_id, song_id
    FROM songs
    LEFT JOIN artists ON artists.artist_id=songs.artist_id
    LEFT JOIN genres ON genres.genre_id=songs.genre_id
    LEFT JOIN types ON types.type_id=artist_type_id";

    public function __construct($connection) {
        $this->pdo = $connection;
    }

    public function getSingleSong($songID){
        $sql = self::$sqlSearch. ' WHERE song_id = :songID';
        $results = DatabaseHelper::runQuery($this->pdo, $sql, $songID, ":songID");
        return $results -> fetchAll();
    }

    public function getSongs($songID){
        //for multiple songs
        $sql = self::$sqlSearch. ' WHERE song_id IN ('.$songID.')';
        $results = DatabaseHelper::runBasicQuery($this->pdo, $sql);
        return $results -> fetchAll();
    }


    /*** SEARCH FUNCTIONS ***/
    public function searchByAll(){
        $sql = self::$sqlSearch;
        $results = DatabaseHelper::runBasicQuery($this->pdo,$sql);
        return $results -> fetchAll();
    }

    public function searchByTitle($title){
        $sql = self::$sqlSearch." WHERE title LIKE :songTitle"; //near match because user can search partial
        $results = DatabaseHelper::runQuery($this->pdo, $sql, "%$title%", ':songTitle');
        return $results -> fetchAll();
    }

    public function searchByYearGreater($greater){
        $sql = self::$sqlSearch." WHERE year >= :great";
        $results = DatabaseHelper::runQuery($this->pdo, $sql, $greater, ":great");
        return $results -> fetchAll();
    }

    public function searchByYearLesser($less){
        $sql = self::$sqlSearch." WHERE year <= :less";
        $results = DatabaseHelper::runQuery($this->pdo, $sql, $less, ":less");
        return $results -> fetchAll();
    }

    public function searchByPopularityGreater($greater){
        $sql = self::$sqlSearch ." WHERE popularity >= :great";
        $results = DatabaseHelper::runQuery($this->pdo, $sql, $greater, ":great");
        return $results -> fetchAll();
    }

    public function searchByPopularityLesser($less){
        $sql = self::$sqlSearch ." WHERE popularity <= :less";
        $results = DatabaseHelper::runQuery($this->pdo, $sql, $less, ":less");
        return $results -> fetchAll();
    }

    public function searchByArtist($artist){
        $sql = self::$sqlSearch." WHERE artist_name = :artist";
        $results = DatabaseHelper::runQuery($this->pdo, $sql, $artist, ':artist');
        return $results -> fetchAll();
    }

    public function searchByGenre($genre){
        $sql = self::$sqlSearch." WHERE genre_name LIKE :genre";
        $results = DatabaseHelper::runQuery($this->pdo, $sql, $genre, ':genre');
        return $results -> fetchAll();
    }

    /***TOP 10 FUNCTIONS***/
    public function getTopPopularSongs(){
        $sql = "SELECT popularity, artist_name as name, title, songs.artist_id, artists.artist_id, song_id
        FROM songs
        INNER JOIN artists
        ON artists.artist_id = songs.artist_id
        GROUP BY title 
        ORDER BY popularity DESC LIMIT 10";
        $results = DatabaseHelper::runBasicQuery($this->pdo, $sql);
        return $results -> fetchAll();
    }

    public function getTopOneHitsSongs(){
        $sql = "SELECT artist_name as name, title, COUNT(title) as numSongs, popularity, songs.artist_id, song_id
        FROM songs
        INNER JOIN artists
        ON artists.artist_id = songs.artist_id
        GROUP BY artist_name 
        HAVING COUNT(title) = 1
        ORDER BY popularity DESC LIMIT 10";
        $results = DatabaseHelper::runBasicQuery($this->pdo, $sql);
        return $results -> fetchAll();
    }

    public function getTopAcousticSongs(){
        $sql = "SELECT title, acousticness, duration, artist_name as name, song_id, artists.artist_id
        FROM songs
        INNER JOIN artists ON artists.artist_id=songs.artist_id
        GROUP BY title 
        HAVING acousticness > 40
        ORDER BY duration DESC LIMIT 10";
        $results = DatabaseHelper::runBasicQuery($this->pdo, $sql);
        return $results -> fetchAll();
    }

    public function getTopClubSongs(){
        $sql = "SELECT title, danceability, song_id, artist_name as name, artists.artist_id
        FROM songs
        INNER JOIN artists ON artists.artist_id=songs.artist_id
        GROUP BY title 
        HAVING danceability > 80
        ORDER BY ((danceability*1.6)+(energy*1.4)) DESC LIMIT 10";
        $results = DatabaseHelper::runBasicQuery($this->pdo, $sql);
        return $results -> fetchAll();
    }

    public function getTopRunningSongs(){
        $sql = "SELECT title, bpm, song_id, artist_name as name, artists.artist_id
        FROM songs
        INNER JOIN artists ON artists.artist_id=songs.artist_id
        GROUP BY title 
        HAVING bpm > 100 AND bpm < 115
        ORDER BY ((energy*1.3)+(valence*1.6)) DESC LIMIT 10";
        $results = DatabaseHelper::runBasicQuery($this->pdo, $sql);
        return $results -> fetchAll();
    }

    public function getTopStudySongs(){
        $sql = "SELECT title, bpm, speechiness, song_id, artist_name as name, artists.artist_id
        FROM songs
        INNER JOIN artists ON artists.artist_id=songs.artist_id
        GROUP BY title 
        HAVING (bpm > 100 AND bpm < 115) AND (speechiness > 1 AND speechiness < 20)
        ORDER BY ((acousticness*0.8)+(100-speechiness)+(100-valence)) DESC LIMIT 10";
        $results = DatabaseHelper::runBasicQuery($this->pdo, $sql);
        return $results -> fetchAll();
    }

}

class ArtistDB{
    public function __construct($connection) {
        $this->pdo = $connection;
    }

    public function getArtistNames(){
        $sql = "SELECT artist_name as name FROM artists";
        $results = DatabaseHelper::runBasicQuery($this->pdo,$sql);
        return $results -> fetchAll();
    }
    
    public function getTopArtists(){
        $sql = "SELECT artist_name as name, COUNT(title) as numSongs, songs.artist_id, title ,song_id
        FROM artists
        INNER JOIN songs
        ON songs.artist_id = artists.artist_id
        GROUP BY artist_name 
        ORDER BY Count(title) DESC LIMIT 10";
        $results = DatabaseHelper::runBasicQuery($this->pdo, $sql);
        return $results -> fetchAll();
    }
}

class GenreDB{
    public function __construct($connection) {
        $this->pdo = $connection;
    }

    public function getGenres(){
        $sql = "SELECT genre_name as genre FROM genres";
        $results = DatabaseHelper::runBasicQuery($this->pdo,$sql);
        return $results -> fetchAll();
    }

    public function getTopGenres(){
        $sql = "SELECT genre_name as genre, COUNT(title) as numSongs, genres.genre_id
        FROM genres
        INNER JOIN songs
        ON songs.genre_id = genres.genre_id
        GROUP BY genre 
        ORDER BY COUNT(title) DESC LIMIT 10";
        $results = DatabaseHelper::runBasicQuery($this->pdo, $sql);
        return $results -> fetchAll();
    }
}

?>