<?php
    require_once('config.inc.php');
    include('includes\database-helper.inc.php');

    function getDBSongData(){
        try{
            $pdo = DatabaseHelper::createConnection(DBCONNSTRING,DBUSER,DBPASS);
            $songGate = new SongDB($pdo);
            $data = $songGate -> searchByAll(); 
            //this is to catch cases where user clicked submit with no input
            //made assumption that if no input is in but user clicked search it will display all songs
            
            if(!isset($_GET['search-rad'])){
                //if user went directly to browse page remove the error line here
                return $data;
            }

            $radType = $_GET['search-rad'];
            switch ($radType){
                case 'title-rad':
                    if(!empty($_GET['title'])){
                        $data = $songGate -> searchByTitle($_GET['title']);
                    }
                    break;
                case 'artist-rad':
                    if(!empty($_GET['artist'])){
                        $data = $songGate -> searchByArtist($_GET['artist']);
                    }
                    break;
                case 'genre-rad':
                    if(!empty($_GET['genres'])){
                        $data = $songGate -> searchByGenre($_GET['genres']);
                    }
                    break;
                case 'year-rad':
                    $subRadType = $_GET['years-rad'];
                    if($subRadType == 'year-rad-great' and !empty($_GET['year-great'])){
                    $data = $songGate -> searchByYearGreater($_GET['year-great'] );
                    }
                    else if($subRadType == 'year-rad-less' and !empty($_GET['year-less'])){
                    $data = $songGate -> searchByYearLesser($_GET['year-less'] );
                    }
                    break;
                case 'pop-rad':
                    $subRadType = $_GET['popu-rad'];
                    if($subRadType == 'pop-rad-great' and !empty($_GET['pop-great'])){
                    $data = $songGate -> searchByPopularityGreater($_GET['pop-great'] );
                    }
                    else if($subRadType == 'pop-rad-less' and !empty($_GET['pop-less'])){
                        $data = $songGate -> searchByPopularityLesser($_GET['pop-less'] );
                    }
                    break;
            }
            

            return $data;
    
        }catch (Exception $e){
            die($e ->getMessage());
        }    
    }

?>