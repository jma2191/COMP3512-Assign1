<?php
    require_once('includes\config.inc.php');
    include('includes\head-and-footer.inc.php');
    include('includes\database-helper.inc.php');

    $githubLink = "https://github.com/jma2191/COMP3512-Assign1";

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
    <head>
    <?php 
    generateHeader(); 
    generateNav();
    ?>
    <link rel="stylesheet" href="css\home.css" />
    <link rel="stylesheet" href="css\nav.css" />
    <link rel="stylesheet" href="css\footer.css" />
    </head>
<body>
<main>
    <h1>Home Page</h1>
    <div class="description">
        COMP 3512 Assignment 1 &copy; Jessica Ma Fall 2022 <br/>
        Git Hub Repository: <a href='<?=$githubLink?>'><?=$githubLink?></a>  
    </div>
    <section class="grid-container">
        <div class="grid grid-1">
            <h2>Top Genres</h2>
            <div>
                <?php
                    try{
                        $data = $genreGate->getTopGenres();
                        echo "<table>";
                        echo "<th>Genre</th>";
                        echo "<th>Number of Songs</th>";
                        foreach($data as $value){
                        echo "<tr>";
                        echo "<td> <a href='browse-search-result-page.php?search-rad=genre-rad&title=&artist=&genres=".$value['genre']."&year-less=&year-great=&pop-less=&pop-great='>".$value['genre']."</a></td>";
                        echo "<td>". $value['numSongs']."</td>";
                        echo "</tr>";
                        }
                        echo "</table>";
                    }catch (Exception $e){
                        die($e ->getMessage());
                    }        
                ?>
            </div>
        </div>
        <div class="grid">
            <h2>Top Artists</h2>
            <div>
            <?php
                try{
                    $data = $artGate->getTopArtists();
                    echo "<table>";
                    echo "<th>Artist</th>";
                    echo "<th>Number of Songs</th>";
                    foreach($data as $value){
                    echo "<tr>";
                    echo "<td><a href='browse-search-result-page.php?search-rad=artist-rad&title=&artist=".$value['name']."&genres=&year-less=&year-great=&pop-less=&pop-great='>".$value['name']."</a></td>";
                    echo "<td>".$value['numSongs'] ."</td>";
                    echo "</tr>";
                    }
                    echo "</table>";
                }catch (Exception $e){
                    die($e ->getMessage());
                }            
            ?>
            </div>
        </div>
        <div class="grid">
            <h2>Popular Songs</h2>
            <div>
            <?php
                try{
                    generateHomeList($songGate->getTopPopularSongs());
                }catch (Exception $e){
                    die($e ->getMessage());
                }        
            ?>
            </div>
        </div>
        <div class="grid">
            <h2>One-hit Wonders</h2>
            <div>
            <?php
                try{
                    generateHomeList($songGate->getTopOneHitsSongs());
                }catch (Exception $e){
                    die($e ->getMessage());
                }        
            ?>
            </div>
        </div>
        <div class="grid">
            <h2>Acoustic Songs</h2>
            <div>
            <?php
                try{
                    generateHomeList($songGate->getTopAcousticSongs());
                }catch (Exception $e){
                    die($e ->getMessage());
                }        
            ?>
            </div>
        </div>
        <div class="grid">
            <h2>Club Songs</h2>
            <div>
            <?php
                try{
                    generateHomeList($songGate->getTopClubSongs());
                }catch (Exception $e){
                    die($e ->getMessage());
                }        
            ?>
            </div>
        </div>
        <div class="grid">
            <h2>Running Songs</h2>
            <div>
            <?php
                try{
                    generateHomeList($songGate->getTopRunningSongs());
                }catch (Exception $e){
                    die($e ->getMessage());
                }        
            ?>
            </div>
        </div>
        <div class="grid">
            <h2>Studying Songs</h2>
            <div>
            <?php
                try{
                    generateHomeList($songGate->getTopStudySongs());
                }catch (Exception $e){
                    die($e ->getMessage());
                }  
            ?>
            </div>
        </div>
    </section>
</main>  
<?php generateFooter(); ?> 
</body>
</html>

<?php 

function generateHomeList($data){
    echo "<table>";
    echo "<th>Title</th>";
    echo "<th>Artist</th>";
    foreach($data as $value){
    echo "<tr>";
    echo "<td><a href='single-song-page.php?song_id=".$value['song_id']."'>".$value['title']."</a></td>";
    echo "<td>".$value['name']."</td>";
    echo "</tr>";
    }
    echo "</table>";
}


$pdo =null ?>

