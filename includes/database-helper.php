<?php
class DatabaseHelper{
    public static function createConnection($conn, $username, $password){
        $pdo = new PDO($conn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    public static function runBasicQuery($pdo, $sql){
        //mainly used for querying that doesn't have user input
        return $pdo -> query($sql);
    }

    public static function runQuery($pdo, $sql){
        //used for sections where user input is involved but is limited
        $statement = $pdo->prepare($sql);
        $statement -> execute();
        return $statement;
    }

    public static function runQuerySinglePrepare($pdo, $sql, $value, $replace){
        //used for when user input is involved and has no limitations
        //only does basic prevention
        $statement = $pdo->prepare($sql);
        $statement -> bindValue($replace, $value, PDO::PARAM_STR);
        $statement -> execute();
        return $statement;
    }
}

class SongDB{

    private static $sqlSearch = "SELECT title, artist_name as artist, year, genre, popularity
    FROM songs 
    LEFT JOIN artists ON artists.artist_id=songs.artist_id
    LEFT JOIN genres ON genres.genre_id=songs.genre_id
    LEFT JOIN types ON types.type_id=artist_type_id";

    public function __construct($connection) {
        $this->pdo = $connection;
    }

    public function getSingleSong($songTitle){
        $sql = 'SELECT title, artist_name as name, type_name as type, genre_name as genre, year, duration, bpm, energy, danceability, liveness, valence, acousticness, speechiness, popularity, songs.artist_id, artist_type_id, songs.genre_id
        FROM songs 
        LEFT JOIN artists ON artists.artist_id=songs.artist_id
        LEFT JOIN genres ON genres.genre_id=songs.genre_id
        LEFT JOIN types ON types.type_id=artist_type_id
        WHERE title = :songTitle;'; //may need to be change to song id
        $results = DatabaseHelper::runQuerySinglePrepare($this->pdo, $sql, $songTitle, ':songTitle');
        return $results -> fetchAll();
    }

    public function searchByTitle($title){
        $sql = self::$sqlSearch." WHERE title LIKE %:songTitle%"; //near match because user can search partial
        $results = DatabaseHelper::runQuerySinglePrepare($this->pdo, $sql, $title, ':songTitle');
        return $results -> fetchAll();
    }

    public function searchByYear($less, $greater){
        $sql = self::$sqlSearch." WHERE year <= $greater AND year >= $less";
        $results = DatabaseHelper::runQuery($this->pdo, $sql);
        return $results -> fetchAll();
    }

    public function searchByPopularity($less, $greater){
        $sql = self::$sqlSearch ." WHERE popularity <= $greater AND year >= $less";
        $results = DatabaseHelper::runQuery($this->pdo, $sql);
        return $results -> fetchAll();
    }

    public function searchByArtist($artist){
        $sql = self::$sqlSearch." WHERE artist = :artist";
        $results = DatabaseHelper::runQuerySinglePrepare($this->pdo, $sql, $artist, ':artist');
        return $results -> fetchAll();
    }

    public function searchByGenre($genre){
        $sql = self::$sqlSearch." WHERE genre = :genre";
        $results = DatabaseHelper::runQuerySinglePrepare($this->pdo, $sql, $title, ':genre');
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
}

?>