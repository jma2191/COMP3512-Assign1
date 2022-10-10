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
            <input type="radio" id="title-rad" name="search-rad">
            <label for="title-rad">Title</label>
            <input type="text" id="title" name="title">
            <br/>
            <input type="radio" id="artist-rad" name="search-rad">
            <label for="artist-rad">Artist</label>
                <?php
                    $data = $artGate -> getArtistNames();
                    echo '<select id="artist" name="artist" value="">';
                    echo '<option value="" selected="selected" hidden> Select Artist Name </option>';
                    foreach($data as $value){
                        echo "<option value='".$value['name']."'>".$value['name'] ."</option>";
                    }
                    echo '</select>';
                ?>
                <div>
                <input type="radio" id="genre-rad" name="search-rad">
                <label for="genre-rad">Genre</label>
                <?php
                    $data = $genGate -> getGenres();
                    echo '<select id="genres" name="genres" value="">';
                    echo '<option value="" selected="selected" hidden> Select a Genre </option>';
                    foreach($data as $value){
                        echo "<option value='".$value['genre']."'>".$value['genre'] ."</option>";
                    }
                    echo '</select>';
                ?>
                </div>
                <div>
                <input type="radio" id="year-rad" name="search-rad">
                <label for="year-rad">Year</label>
                    <div>
                            <input type="number" id="year-less" name="year-less">
                            to
                            <input type="number" id="year-great" name="year-great">
                   </div>
                </div>
                <div>
                <input type="radio" id="pop-rad" name="search-rad">
                <label for="pop-rad">Popularity</label>
                    <div>
                            <input type="number" id="pop-less" name="pop-less">
                            to
                            <input type="number" id="pop-great" name="pop-great">
                    </div>
                </div>
                <input type="submit" id="submit-btn" value="Search">
        </form>
    </section>
</main>  
<?php generateFooter(); ?> 
</body>
</html>

