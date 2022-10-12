<?php
    require_once('config.inc.php');
    include('includes\database-helper.php');
    
    function displaySearch(){
        $data = getDBSongData();

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
            echo "<td> <form method='post' action='view-favourites-page.php'><button>Add to Favourites </button></form> </td>";
            echo "<td> <form method='get' action='single-song-page.php?".$value['song_id']."'><button type='submit' value='".$value['song_id']."' name='song_id'>View</button></form> </td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    function getDBSongData(){
        try{
            $pdo = DatabaseHelper::createConnection(DBCONNSTRING,DBUSER,DBPASS);
            $songGate = new SongDB($pdo);
            $data = null;

            /*$radType = $_POST['search-rad'];
            switch ($radType){
                case 'title-rad':
                    $data = $songGate -> searchByTitle($_GET['title']);
                case 'artist-rad':
                    $data = $songGate -> searchByArtist($_GET['artist']);
            }*/

            //find better way to validate if raido buttons are selected
            if(!empty($_GET['title'])){
                $data = $songGate -> searchByTitle($_GET['title']);
            }
            else if(!empty($_GET['artist'])){
                $data = $songGate -> searchByArtist($_GET['artist']);
            }
            else if(!empty($_GET['genres'])){
                $data = $songGate -> searchByGenre($_GET['genres']);
            }
            else if(!empty($_GET['year-less']) or !empty($_GET['year-great'])){
                if(!empty($_GET['year-great'])){
                    $data = $songGate -> searchByYearGreater($_GET['year-great'] );
                }
                else{
                    $data = $songGate -> searchByYearLesser($_GET['year-less'] );
                }
            }
            else if(!empty($_GET['pop-less']) or !empty($_GET['pop-great'])){
                if(!empty($_GET['pop-great'])){
                    $data = $songGate -> searchByPopularityGreater($_GET['pop-great'] );
                }
                else{
                    $data = $songGate -> searchByPopularityLesser($_GET['pop-less'] );
                }
            }
            else{
                $data = $songGate -> searchByAll();
            }


            return $data;
    
        }catch (Exception $e){
            die($e ->getMessage());
        }    
    }

?>