<?php
    function setMyCookies(){
        if(isset($_POST['add'])){
            addFavourite();
            header("Refresh:0"); //if condition will prevent it from constantly refreshing
        }   

        if(!isset($_COOKIE['favourites'])){
            //if there is no cookies we still want the page to function as normal
            return;
        }


        if(isset($_POST['remove'])){
            removeFavourite();
            header("Refresh:0"); //if condition will prevent it from constantly refreshing
        } 

    }

    function addFavourite(){
        if(isset($_COOKIE['favourites'])){
            $value = $_COOKIE['favourites'];
        }
        else {
            $value = "";
        }

        if(str_contains($value,$_POST['add'].", ")){
            return;
        }
        else{
            $value .= $_POST['add'].", ";
        }

        //only makes favourites last for 1 day find away to make it last perm
        $expiryTime = time()+(60*60*24);
        
        setcookie("favourites", $value, $expiryTime);
    }

    function removeFavourite(){
        $value = $_COOKIE['favourites'];
        $value = str_replace($_POST['remove'].", ","",$value);

        //only makes favourites last for 1 day find away to make it last perm
        $expiryTime = time()+(60*60*24);
        
        setcookie("favourites", $value, $expiryTime);
    }
?>