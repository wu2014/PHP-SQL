<?php
    // Start the session and various includes 
    require_once('./includes/startsession.inc.php');
    // insert page header and navigation links
    $page_title = 'Home Page';
    require_once('./includes/headerRSS.inc.php'); 
    require_once('./includes/navmenu.inc.php');
?>

    <div id="content">
       <p>This site is intended for people who are intrested in classic car search</p> 
       <img src="./images/car.gif" alt="Car Icon">   
    </div>
<?php 
require_once('./includes/footer.inc.php');
?>


