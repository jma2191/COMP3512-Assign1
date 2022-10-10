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
        $sql = 'SELECT title, year, bpm, energy, danceability, liveness, valence, acousticness, speechiness, popularity FROM songs WHERE title = :songTitle';
        $results = DatabaseHelper::runQuery($pdo, $sql, $songTitle, ':songTitle');
        return $results->fetchAll();
    }
}


?>