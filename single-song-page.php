<?php
    require_once('config.inc.php');
    include('includes\head-and-footer.php');
    include('includes\database-helper.php');

    try{
        $pdo = DatabaseHelper::createConnection(DBCONNSTRING,DBUSER,DBPASS);
        $songGate = new SongDB($pdo);

    }catch (Exception $e){
        die($e ->getMessage());
    }
?>

<!DOCTYPE html>
<html>
<?php generateHeader(); ?>
<body>
<main class="grid-container">
    <?php
        $data = $songGate -> getSingleSong($_GET['song_id']);
        foreach($data as $value){
            echo $value['title'].', '.$value['name'].', '.$value['type'].', '.$value['genre'].', '.$value['year'].','. $value['duration'] .'<br/>';
            echo "<ul>";
            echo '<li> <label for="bpm"> bpm:</label> <progress id="bpm" value="'.$value['bpm'].'" max=100> '.$value['bpm'].'</progress> </li>';
            echo '<li> <label for="energy"> energy:</label> <progress id="energy". value="'.$value['energy'].'" max=100> '.$value['energy'].'</progress> </li>';
            echo '<li> <label for="danceability"> danceability:</label> <progress id="danceability" value="'.$value['danceability'].'" max=100> '.$value['danceability'].'</progress> </li>';
            echo '<li> <label for="liveness"> liveness:</label> <progress id="liveness" value="'.$value['liveness'].'" max=100> '.$value['liveness'].'</progress> </li>';            
            echo '<li> <label for="valence"> valence:</label> <progress id="valence" value="'.$value['valence'].'" max=100> '.$value['valence'].'</progress> </li>';
            echo '<li> <label for="acousticness"> acousticness:</label> <progress id="acousticness" value="'.$value['acousticness'].'" max=100> '.$value['acousticness'].'</progress> </li>';
            echo '<li> <label for="speechiness"> speechiness:</label> <progress id="speechiness" value="'.$value['speechiness'].'" max=100> '.$value['speechiness'].'</progress> </li>';
            echo '<li> <label for="popularity"> popularity:</label> <progress id="popularity" value="'.$value['popularity'].'" max=100> '.$value['popularity'].'</progress> </li>';
            echo '</ul>';
        }
    ?>
</main>  
<?php generateFooter(); ?> 
</body>
</html>

<?php $pdo =null ?>

