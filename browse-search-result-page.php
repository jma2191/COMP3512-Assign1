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
    <div class='grid grid-item1'>
    <form action="browse-search-result-page.php"> <input type="submit" value="View All"/> </form>
    </div>
    <section>
        <?php displaySearch(); ?>
    </section>
</main>  
<?php generateFooter(); ?> 
</body>
</html>

