<?php
class DatabaseHelper{
    public static function createConnection($conn, $username, $password){
        $pdo = new PDO($conn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    public static function runQuery($pdo, $sql, $value, $replace){
        //basic sql injection prevention
        $statement = $pdo->prepare($sql);
        $statement -> bindValue($replace, $value, PDO::PARAM_STR);
        $statement -> execute();
        return $statement;
    }
}

class SongDB{

    public function _construct($pdoConn){
        $this->$myPDO = $pdoConn;
    }

    public function getSingleSong($pdo,$songTitle){
        $sql = 'SELECT title, artist_name as name, type_name as type, genre_name as genre, year, duration, bpm, energy, danceability, liveness, valence, acousticness, speechiness, popularity, songs.artist_id, artist_type_id, songs.genre_id
        FROM songs 
        LEFT JOIN artists ON artists.artist_id=songs.artist_id
        LEFT JOIN genres ON genres.genre_id=songs.genre_id
        LEFT JOIN types ON types.type_id=artist_type_id
        WHERE title = :songTitle;';
        $results = DatabaseHelper::runQuery($pdo, $sql, $songTitle, ':songTitle');
        return $results->fetchAll();
    }
}


?>