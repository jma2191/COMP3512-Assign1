<?php
    require_once('config.inc.php');
    include('includes\head-and-footer.php');
    include('includes\database-helper.php');

    try{
        $pdo = DatabaseHelper::createConnection(DBCONNSTRING,DBUSER,DBPASS);
        $songGate = new SongDB($pdo);
        $artGate = new ArtistDB($pdo);
        $genGate = new GenreDB($pdo);

    }catch (Exception $e){
        die($e ->getMessage());
    }
?>

<!DOCTYPE html>
<html>
<?php generateHeader(); ?>
<body>
<main class="grid-container">
    <section>
        <h1>Search By </h1>
        <form method="get" action="browse-search-result-page.php">
            <div>
                <input type="radio" id="title-rad" name="search-rad" value="title-rad" checked/>
                <label for="title-rad">Title</label>
                <input type="text" id="title" name="title"/>
            </div>
            <div>
                <input type="radio" id="artist-rad" name="search-rad" value="artist-rad"/>
                <label for="artist-rad">Artist</label>
                    <?php
                        $data = $artGate -> getArtistNames();
                        echo '<select id="artist" name="artist" value=""/>';
                        echo '<option value="" selected="selected" hidden> Select Artist Name </option>';
                        foreach($data as $value){
                            echo "<option value='".$value['name']."'>".$value['name'] ."</option>";
                        }
                        echo '</select>';
                    ?>
            </div>
            <div>
                <input type="radio" id="genre-rad" name="search-rad" value="genre-rad"/>
                <label for="genre-rad">Genre</label>
                <?php
                    $data = $genGate -> getGenres();
                    echo '<select id="genres" name="genres" value=""/>';
                    echo '<option value="" selected="selected" hidden> Select a Genre </option>';
                    foreach($data as $value){
                        echo "<option value='".$value['genre']."'>".$value['genre'] ."</option>";
                    }
                    echo '</select>';
                ?>
            </div>
            <div>
                <input type="radio" id="year-rad" name="search-rad" value="year-rad"/>
                <label for="year-rad">Year</label>
                    <div>
                            <input for="year-rad" type="radio" id="year-rad-less" name="years-rad" value="year-rad-less"/>
                            <label for="year-rad-less">Less</label>
                            <input for="year-rad-less" type="number" id="year-less" name="year-less"/>
                            <input type="radio" id="year-rad-great" name="years-rad" value="year-rad-great"/>
                            <label for="year-rad-great">Greater</label>
                            <input for="year-rad-great" type="number" id="year-great" name="year-great"/>
                   </div>
            </div>
            <div>
                <input type="radio" id="pop-rad" name="search-rad" value="pop-rad"/>
                <label for="pop-rad">Popularity</label>
                    <div>
                            <input for="pop-rad" type="radio" id="pop-rad-less" name="popu-rad" value="pop-rad-less"/>
                            <label for="pop-rad-less">Less</label>
                            <input for="pop-rad-less" type="number" id="pop-less" name="pop-less"/>
                            <input type="radio" id="pop-rad-great" name="popu-rad" value="pop-rad-great"/>
                            <label for="pop-rad-great">Greater</label>
                            <input for="pop-rad-great" type="number" id="pop-great" name="pop-great"/>
                    </div>
            </div>
            <input type="submit" id="submit-btn" value="Search">
        </form>
    </section>
</main>  
<?php generateFooter(); ?> 
</body>
</html>

