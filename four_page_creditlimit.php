<?php
    // Start the session and various includes 
    require_once('./includes/startsession.inc.php');   
    require_once('./includes/appvars.inc.php');
    require_once('./includes/connectvars.inc.php');
    require_once('./includes/functions.inc.php');

    // Make sure the user is logged in before going any further.
    if (!isset($_SESSION['employeeNumber'])) {
        echo '<p class="login">Please <a href="login.php">log in</a> to access this page.</p>';
        exit();
    }

    // Connect to the database
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    // First grab the creditLimit
    $query = "SELECT creditLimit FROM customers";
    $data = mysqli_query($dbc, $query);
    $creditLimit_array = array ();
    while ($row = mysqli_fetch_array($data)) {
        array_push($creditLimit_array, $row['creditLimit']);
    }

    // insert page header and navigation links
    $page_title = 'Credit Limit Report';
    require_once('./includes/htmlhead.inc.php'); 
    require_once('./includes/navmenu.inc.php'); 
?>

    <div id="content">   
 <?php 
    $graph_array = fill_graph_array ($creditLimit_array);
    $graph_scale = make_graph_scale (count($creditLimit_array));
    // Generate and display the mismatched category bar graph image
    echo '<h4>Credit Limit breakdown:</h4>';
    draw_bar_graph(480, 320, $graph_array, $graph_scale, MM_UPLOADPATH . $_SESSION['employeeNumber'] . '-creditlimit.png');
    echo '<img src="' . MM_UPLOADPATH . $_SESSION['employeeNumber'] . '-creditlimit.png" alt="credit limit graph"><br>';  
?>
    </div>
  
<?php 
require_once('./includes/footer.inc.php'); 
mysqli_close($dbc);
?>    
   