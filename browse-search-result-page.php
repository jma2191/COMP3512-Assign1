<?php

    include('includes\head-and-footer.php');
    include('includes\browse.inc.php');
?>

<!DOCTYPE html>
<html>
<?php generateHeader(); ?>
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

