<?php

    include('includes\head-and-footer.inc.php');
    include('includes\browse.inc.php');
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
    <link rel="stylesheet" href="css\browse.css" />

</head>
<body>
<main class="grid-container">
    <div class='view-all'>
        <form action="browse-search-result-page.php"> <input type="submit" value="View All"/> </form>
    </div>
        <?php         
            $data = getDBSongData();

            if(count($data) == 0){
                echo "<div class='search-no-results'> There seems to be no song that meets your search conditions </div>";
            }

            echo "<section>";
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
                echo "<td> <a href='view-favourites-page.php?add=".$value['song_id']."'> <button>Add to Favourites</button></a> </td>";
                echo "<td> <form method='get' action='single-song-page.php?".$value['song_id']."'><button type='submit' value='".$value['song_id']."' name='song_id'>View</button></form> </td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "</section>";
        ?>
</main>  
<?php generateFooter(); ?> 
</body>
</html>

