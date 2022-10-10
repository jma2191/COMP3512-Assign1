<?php
    function generateHeader(){
        echo "<head>";
        echo "<title> COMP 3512 Assign1 - Jessica Ma";
        echo "</head>";
    }

    function generateFooter(){
        $githubLink = "https://github.com/jma2191/COMP3512-Assign1";

        echo "<footer>";
        echo "COMP3512 &copy; Jessica Ma </br>";
        echo "Github Repo: $githubLink";
        echo "</footer>";
    }
?>