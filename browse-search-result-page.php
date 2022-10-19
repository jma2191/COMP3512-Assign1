<?php

    include('includes\head-and-footer.php');
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
</head>
<body>
<main class="grid-container">
    <form action="browse-search-result-page.php"> <input type="submit" value="View All"/> </form>
    <section>
        <?php displaySearch(); ?>
    </section>
</main>  
<?php generateFooter(); ?> 
</body>
</html>

