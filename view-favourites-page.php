<?php
    require_once('includes\config.inc.php');
    include('includes\database-helper.inc.php');
    include('includes\head-and-footer.inc.php');
    include('includes\favourites.inc.php');

    setUpSession();

    try{
        $pdo = DatabaseHelper::createConnection(DBCONNSTRING,DBUSER,DBPASS);
        $songGate = new SongDB($pdo);
        
        $data = array(); //assuming there are none to begin with
        if(isset($_SESSION['favourites'])){
            $sql = getFavouriteSongIDs();
            if($sql == ""){
                $data = array();//unlikely it will change before hand but just incase
            }
            else if(substr_count($sql,",")>=1){
                $data = $songGate -> getSongs($sql);
            }else{
                $data = $songGate -> getSingleSong($sql);
            }
        }

        $pdo = null;
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
    <link rel="stylesheet" href="css\browse.css" />

</head>
<body>
<main class="grid-container">
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
                echo "<td> <a href='view-favourites-page.php?remove=".$value['song_id']."'><button>Remove</button></a> </td>";
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