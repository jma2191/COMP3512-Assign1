<?php
    function generateHeader(){
        echo "<meta charset=utf-8>";
        echo "<title> COMP 3512 Assign1 - Jessica Ma</title>";
    }

    function generateNav(){
        echo "<nav>";
        echo "<a href='home-page.php'>Home</a>";
        echo "<a href='search-page.php'>Search</a>";
        echo "<a href='browse-search-result-page.php'>Browse</a>";
        echo "<a href='view-favourites-page.php'>Favourites</a>";
        echo "</nav>";
    }

    function generateFooter(){
        $githubLink = "https://github.com/jma2191/COMP3512-Assign1";

        echo "<footer>";
        echo "<p> COMP3512 &copy; Jessica Ma </br>";
        echo "<a href=$githubLink>Github Repository</a>";
        echo "</p>";
        echo "</footer>";
    }
?>