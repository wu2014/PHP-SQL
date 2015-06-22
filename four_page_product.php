<?php
    // database connection includes
    require_once('./includes/connectvars.inc.php');
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
        or die('Cannot connect to database');
    $output = 'No product information';

// GET product information
    if (isset($_GET['pid'])) {
        $product_line_code = trim ($_GET['pid']);
        $query = "SELECT * FROM productlines WHERE productLineCode = '$product_line_code'";
        $result = mysqli_query($dbc, $query)
            or die ("Error querying database =>$query");
        $num_rows = mysqli_num_rows ($result);
        
        if ($num_rows != 0) {
            while ($row = mysqli_fetch_array($result)) {
                $product_line = $row['productLine'];
                $text_description = $row['textDescription'];
                $html_description = $row['htmlDescription'];              

                $output = "<p><em>Product Line: </em>$product_line</p>
                           <p><em>Text Description: </em>$text_description</p>
                           <p><em>HTML Description: </em>$html_description</p>";   
            } // end while ($row = mysqli_fetch_array($result))
        } else {$output = 'The item could not be found';}   
    } // end if(isset($_GET['pid']))
    // insert header 
    $page_title = 'Product information';
    require_once('./includes/headerRSS.inc.php'); 
?>    
 
    <div id="content">   
        <h2>Vehicle types</h2>
        <div>
            <?=$output ?>
        </div>
    </div>
<?php 
require_once('./includes/footer.inc.php'); 
?>