<?php
    // start the session
    require_once('./includes/startsession.inc.php');
    // insert header and navigation links
    $page_title = 'Welcome to the Classic Car site';
    require_once('./includes/htmlhead.inc.php');
    require_once('./includes/navmenu.inc.php'); 
?>

    <div id="content">            
<?php
    // if log in, welcome the user
    if (isset($_SESSION['username'])) {
        echo '<p>Welcome'.' ' .$_SESSION['username'].'</P>';
        echo "<p>Feel free to search the classic cars. If you have any question, please contact our company.</p>";
    }  
?>
    </div>
<?php 
require_once('./includes/footer.inc.php'); 
?>