<?php
    require_once('includes\config.inc.php');
    include('includes\head-and-footer.inc.php');
    include('includes\database-helper.inc.php');

    try{
        $pdo = DatabaseHelper::createConnection(DBCONNSTRING,DBUSER,DBPASS);
        $songGate = new SongDB($pdo);

    }catch (Exception $e){
        die($e ->getMessage());
    }
?>

<!DOCTYPE html>
<html>
<head>
    <?php 
    generateHeader(); 
    generateNav();
    ?>
    <link rel="stylesheet" href="css\nav.css" />
    <link rel="stylesheet" href="css\footer.css" />
</head>
<body>
<main class="grid-container">
    <h1>Song Details</h1>
    <?php
        $data = $songGate -> getSingleSong($_GET['song_id']);
        foreach($data as $value){
            echo "<h2>".$value['title']."</h2>";
            echo "<div name='grid grid-item1'>Artist: ".$value['name'];
            echo "<br/>Band Type: ".$value['type'];
            echo "<br/>Genre: ".$value['genre'];
            echo "<br/>Year: ".$value['year'];
            echo "<br/>Duration: ".$value['duration'] ."</div>";
            echo "<div name='grid grid-item2'><table>";
            echo '<tr> <td> bpm: </td> <td> <progress id="bpm" value="'.$value['bpm'].'" max=100> </progress> </td> </tr>';
            echo '<tr> <td> Energy: </td> <td> <progress id="energy". value="'.$value['energy'].'" max=100> </progress> </td> </tr>';
            echo '<tr> <td> Danceability:</td> <td> <progress id="danceability" value="'.$value['danceability'].'" max=100> </progress> </td> </tr>';
            echo '<tr> <td> Liveness:</td> <td> <progress id="liveness" value="'.$value['liveness'].'" max=100> </progress> </td> </tr>';            
            echo '<tr> <td> Valence:</td> <td> <progress id="valence" value="'.$value['valence'].'" max=100> </progress> </td> </tr>';
            echo '<tr> <td> Acousticness:</td> <td> <progress id="acousticness" value="'.$value['acousticness'].'" max=100> </progress> </td> </tr>';
            echo '<tr> <td> Speechiness:</td> <td> <progress id="speechiness" value="'.$value['speechiness'].'" max=100> </progress> </td> </tr>';
            echo '<tr> <td> Popularity:</td> <td> <progress id="popularity" value="'.$value['popularity'].'" max=100> </progress> </td> </tr>';
            echo '</table> </div>';
        }
    ?>
</main>  
<?php generateFooter(); ?> 
</body>
</html>

<?php $pdo =null ?>

