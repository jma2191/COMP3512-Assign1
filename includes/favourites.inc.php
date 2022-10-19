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

        $favourites = $_SESSION['favourites'];
        unset($favourites[$_GET['remove']]); //completely removes it from the array
        $_SESSION['favourites'] = $favourites;
        header("location: view-favourites-page.php"); //refresh page after changes are made
    }

    function getFavouriteSongIDs(){
        //returns a string of song ids fit for sql
        if(!isset($_SESSION['favourites'])){
            return ""; //return nothing if there no favourites
        }

        $string = "";
        $IDList = $_SESSION['favourites'];

        foreach($IDList as $id){
            $string .= $id.",";
        }

        return substr($string,0,-1);//remove the last comma
    }
?>