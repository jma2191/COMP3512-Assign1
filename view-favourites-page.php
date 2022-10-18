<?php
    require_once('config.inc.php');
    include('includes\database-helper.php');
    include('includes\head-and-footer.php');
    include('includes\favourites.inc.php');

    setMyCookies();

    try{
        $pdo = DatabaseHelper::createConnection(DBCONNSTRING,DBUSER,DBPASS);
        $songGate = new SongDB($pdo);

        $data = array(); //assuming there are no cookies to begin with first
        if(isset($_COOKIE['favourites'])){
            $cookie = substr($_COOKIE['favourites'],0,-2);
            if(str_contains($cookie,",")){
                $data = $songGate -> getSongs("(".$cookie.")");
            }
            else{
                $data = $songGate -> getSingleSong($cookie);
            }
        }
    }catch (Exception $e){
        die($e ->getMessage());
    }    
?>
<!DOCTYPE html>
<html>
<?php generateHeader(); ?>
<body>
<main class="grid-container">
    <form action="browse-search-result-page.php"> <input type="submit" value="View All"/> </form>
    <section>
    <?php
            echo "<table>";
            echo "<th> Title </th>";
            echo "<th> Artist </th>";
            echo "<th> Year </th>";
            echo "<th> Genre </th>";
            echo "<th> Popularity </th>";
            echo "<th></th>"; //left empty for the buttons
            echo "<th></th>"; 
            foreach($data as $value){
                echo "<tr>";
                echo "<td>".$value['title']."</td>";
                echo "<td>".$value['name']."</td>";
                echo "<td>".$value['year']."</td>";
                echo "<td>".$value['genre']."</td>";
                echo "<td>".$value['popularity']."</td>";
                echo "<td> <form method='post' action='view-favourites-page.php'><button type='submit' value='".$value['song_id']."' name='remove'>Remove</button></form></td>";
                echo "<td> <form method='get' action='single-song-page.php?".$value['song_id']."'><button type='submit' value='".$value['song_id']."' name='song_id'>View</button></form> </td>";
                echo "</tr>";
            }
            echo "</table>";
        ?>
    </section>
</main>  
<?php generateFooter(); ?> 
</body>
</html>