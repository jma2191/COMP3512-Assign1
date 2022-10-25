<?php
    function setUpSession(){
        session_start();
        if(isset($_GET['add'])){
            addFavourite();
        }   

        if(isset($_GET['remove'])){
            removeFavourite();
        } 
    }

    function addFavourite(){
        if(!isset($_SESSION['favourites'])){
            $_SESSION['favourites'] = [];
        }

        $favourites = $_SESSION['favourites'];
        $favourites[$_GET['add']] = $_GET['add']; //making it assoicative array to have an easy time removing and adding data
        $_SESSION['favourites'] = $favourites;
        header("location: view-favourites-page.php"); //refresh page after changes are made
    }

    function removeFavourite(){
        if(!isset($_SESSION['favourites'])){
            return; // do nothing 
        }

        if($_GET['remove'] == 'all'){
            //remove all condition
            $_SESSION['favourites'] = [];
            header("location: view-favourites-page.php");
            return;
        }

        $favourites = $_SESSION['favourites'];
        unset($favourites[$_GET['remove']]); //completely removes it from the array
        $_SESSION['favourites'] = $favourites;
        //refresh page after changes are made
        header("location: view-favourites-page.php");
    }

    function getFavouriteSongIDs(){
        //returns a string of song ids fit for sql
        $string = "";

        if($_SESSION['favourites'] == 0){
            return $string; //return nothing if there no favourites
        }

        foreach($_SESSION['favourites'] as $id){
            $string .= $id.",";
        }

        return substr($string,0,-1);//remove the last comma for mysql format
    }
?>