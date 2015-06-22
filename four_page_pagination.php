<?php
    // Start the session and various includes
    require_once('./includes/startsession.inc.php');
    require_once('./includes/connectvars.inc.php');
    require_once('./includes/functions.inc.php');

    $sales_rep = "0";
    $output_form = true;
    $output_message = "";

    // Connect to the database and query
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $query = "SELECT productLine FROM productlines"; 
    $result = mysqli_query($dbc, $query); 

    if (isset($_POST['submit'])) {
        // Grab the profile data from the POST     
        $product_line = $_POST['productline'];
        // check for empty fields
        if (empty($_POST['productline'])) {
            $output_message = '<p class="error">'.'Please select your product line</p>';
            $output_form = true;
        } else {
            $output_form = false;             
        }  // end if/else     
    } // end isset($_POST['submit'])

    // Insert header and show the navigation menu
    $page_title = 'Select You Car type';
    require_once('./includes/htmlhead.inc.php');
    require_once('./includes/navmenu.inc.php');   
?>

<?php
    if ($output_form) {
?>
    <div id="content"> 
        <h2>Choose your favorite type. </h2>
        <form action="<?=$_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
            <?=$output_message ?>
            <table>
                <tr>
                    <td>Product Line:</td><td><select name="productline">
                        <option value="0">Select Product Line</option>
                    <?php 
                        while ($row = mysqli_fetch_array($result)) {
                            $pline = $row['productLine'];
                            if ($product_line == $pline) $selected = "selected";
                            else $selected = "";  
                    ?>
                        <option <?=$selected ?> value="<?=$pline ?>"><?=$pline ?></option>
                    <?php     
                        } // end while
                    ?>      
                        </select></td> 
                  </tr>
            </table>
            <input name="submit" type="submit">
        </form> 
    </div>

<?php
    } else {
        $user_selected = $_POST['productline'];
        // Calculate pagination information
        $cur_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $results_per_page = 10;  // number of results per page
        $skip = (($cur_page - 1) * $results_per_page);
  
        // Start generating the table of results
        echo '<table>';
  
        // Generate the search result headings
        echo '<tr class="heading">';
        echo '<td>Product Code</td><td>Product Name</td><td>Description</td><td>Quantity</td><td>Buy Price</td>';
        echo '</tr>';

        // Query to get the total results 
        $query = "SELECT * FROM products WHERE productLine = '$user_selected'";
        $result = mysqli_query($dbc, $query);
        $total = mysqli_num_rows($result);
        $num_pages = ceil($total / $results_per_page);

        // Query again to get just the subset of results
        $query =  $query . " LIMIT $skip, $results_per_page";
        $result = mysqli_query($dbc, $query);
        while ($row = mysqli_fetch_array($result)) {
            echo '<tr class="results">';
            echo '<td class="width1">' . $row['productCode'] . '</td>';
            echo '<td class="width1">' . $row['productName'] . '</td>';
            echo '<td class="width2">' . substr($row['productDescription'], 0, 100). '...</td>';
            echo '<td class="width1">' . $row['quantityInStock'] . '</td>';
            echo '<td class="width1">' . $row['buyPrice'] . '</td>';
            echo '</tr>';
        } 
        echo '</table>';

        // Generate navigational page links if we have more than one page
        if ($num_pages > 1) {
            echo generate_page_links($user_selected, $cur_page, $num_pages);
        }
    }  // end if/else
?>

<?php
  // Insert the page footer
  require_once('./includes/footer.inc.php');
  mysqli_close($dbc);
?>
