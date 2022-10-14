<?php
    require_once('config.inc.php');
    include('includes\head-and-footer.php');
    include('includes\database-helper.php');
    include('includes\home.inc.php');

    try{
        $pdo = DatabaseHelper::createConnection(DBCONNSTRING,DBUSER,DBPASS);
        $songGate = new SongDB($pdo);
        $genreGate = new GenreDB($pdo);
        $artGate = new ArtistDB($pdo);

    }catch (Exception $e){
        die($e ->getMessage());
    }
?>

<!DOCTYPE html>
<html>
<?php generateHeader(); ?>
<body>
<main class="grid-container">
    <h1>Home Page</h1>
    <div>
        <h2>Top Genres</h2>
        <?php
            try{
                $data = $genreGate->getTopGenres();
                echo "<table>";
                echo "<th>Genre</th>";
                echo "<th>Number of Songs</th>";
                foreach($data as $value){
                echo "<tr>";
                echo "<td>".$value['genre']."</td>";
                echo "<td>". $value['numSongs']."</td>";
                echo "</tr>";
                }
                echo "</table>";
            }catch (Exception $e){
                die($e ->getMessage());
            }        
        ?>
    </div>
    <div>
        <h2>Top Artists</h2>
        <?php
            try{
                $data = $artGate->getTopArtists();
                echo "<table>";
                echo "<th>Artist</th>";
                echo "<th>Number of Songs</th>";
                foreach($data as $value){
                echo "<tr>";
                echo "<td>".$value['name']."</td>";
                echo "<td>".$value['numSongs'] ."</td>";
                echo "</tr>";
                }
                echo "</table>";
            }catch (Exception $e){
                die($e ->getMessage());
            }        
        ?>
    </div>
    <div>
        <h2>Popular Songs</h2>
        <?php
            try{
                $data = $songGate->getTopPopularSongs();
                echo "<table>";
                echo "<th>Title</th>";
                echo "<th>Artist</th>";
                echo "<th>Popularity</th>";
                foreach($data as $value){
                echo "<tr>";
                echo "<td>".$value['title']."</td>";
                echo "<td>".$value['name']."</td>";
                echo "<td>".$value['popularity']."</td>";
                echo "</tr>";
                }
                echo "</table>";
            }catch (Exception $e){
                die($e ->getMessage());
            }        
        ?>
    </div>
    <div>
        <h2>One-hit Wonders</h2>
        <?php
            try{
                $data = $songGate->getTopOneHitsSongs();
                echo "<table>";
                echo "<th>Title</th>";
                echo "<th>Artist</th>";
                echo "<th>Popularity</th>";
                foreach($data as $value){
                echo "<tr>";
                echo "<td>".$value['title']."</td>";
                echo "<td>".$value['name']."</td>";
                echo "<td>".$value['popularity']."</td>";
                echo "</tr>";
                }
                echo "</table>";
            }catch (Exception $e){
                die($e ->getMessage());
            }        
        ?>
    </div>
    <div>
        <h2>Acoustic Songs</h2>
        <?php
            try{
                $data = $songGate->getTopAcousticSongs();
                echo "<table>";
                echo "<th>Title</th>";
                echo "<th>Acousticness</th>";
                foreach($data as $value){
                echo "<tr>";
                echo "<td>".$value['title']."</td>";
                echo "<td>".$value['acousticness']."</td>";
                echo "</tr>";
                }
                echo "</table>";
            }catch (Exception $e){
                die($e ->getMessage());
            }        
        ?>
    </div>
    <div>
        <h2>Club Songs</h2>
        <?php
            try{
                $data = $songGate->getTopClubSongs();
                echo "<table>";
                echo "<th>Title</th>";
                echo "<th>Danceability</th>";
                foreach($data as $value){
                echo "<tr>";
                echo "<td>".$value['title']."</td>";
                echo "<td>".$value['danceability']."</td>";
                echo "</tr>";
                }
                echo "</table>";
            }catch (Exception $e){
                die($e ->getMessage());
            }        
        ?>
    </div>
    <div>
        <h2>Running Songs</h2>
        <?php
            try{
                $data = $songGate->getTopRunningSongs();
                echo "<table>";
                echo "<th>Title</th>";
                echo "<th>bpm</th>";
                foreach($data as $value){
                echo "<tr>";
                echo "<td>".$value['title']."</td>";
                echo "<td>". $value['bpm']."</td>";
                echo "</tr>";
                }
                echo "</table>";
            }catch (Exception $e){
                die($e ->getMessage());
            }        
        ?>
    </div>
    <div>
        <h2>Studying Songs</h2>
        <?php
            try{
                $data = $songGate->getTopStudySongs();
                echo "<table>";
                echo "<th>Title</th>";
                echo "<th>bpm</th>";
                echo "<th>Speechiness</th>";
                foreach($data as $value){
                echo "<tr>";
                echo "<td>".$value['title']."</td>";
                echo "<td>". $value['bpm']."</td>";
                echo "<td>". $value['speechiness']."</td>";
                echo "</tr>";
                }
                echo "</table>";
            }catch (Exception $e){
                die($e ->getMessage());
            }        
        ?>
    </div>
</main>  
<?php generateFooter(); ?> 
</body>
</html>

<?php $pdo =null ?>

