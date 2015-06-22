<?php
    // Start the session
    require_once('./includes/startsession.inc.php');
    require_once('./includes/appvars.inc.php');
    require_once('./includes/connectvars.inc.php');

    // Make sure the user is logged in before going any further.
    if (!isset($_SESSION['employeeNumber'])) {
        echo '<p class="login">Please <a href="login.php">log in</a> to access this page.</p>';
        exit();
    }

    $customer_name = "";
    $first_name = "";
    $last_name = "";
    $phone = "";
    $address1 = "";
    $address2 = "";
    $city = "";
    $state = "";
    $post_code = "";
    $country = "";
    $sales_rep = "0";
    $credit_limit ="";
    $output_form = true;
    $output_message = "";

    // Connect to the database
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    $query = "SELECT * FROM employees 
                  WHERE jobTitle = 'Sales Rep' 
                  ORDER BY lastName ASC, firstName ASC"; 
    $result = mysqli_query($dbc, $query) 
        or die('Error querying database');

    if (isset($_POST['submit'])) {
        // Grab the profile data from the POST
        $customer_name = mysqli_real_escape_string($dbc, trim($_POST['customername']));
        $first_name = mysqli_real_escape_string($dbc, trim($_POST['firstname']));
        $last_name = mysqli_real_escape_string($dbc, trim($_POST['lastname']));
        $phone = mysqli_real_escape_string($dbc, trim($_POST['phone']));
        $address1 = mysqli_real_escape_string($dbc, trim($_POST['address1']));
        $address2 = mysqli_real_escape_string($dbc, trim($_POST['address2']));
        $city = mysqli_real_escape_string($dbc, trim($_POST['city']));
        $state = mysqli_real_escape_string($dbc, trim($_POST['state']));
        $post_code = mysqli_real_escape_string($dbc, trim($_POST['postcode']));
        $country = mysqli_real_escape_string($dbc, trim($_POST['country']));
        $sales_rep = $_POST['salesrep'];
        $credit_limit = mysqli_real_escape_string($dbc, trim($_POST['creditlimit'])); 

    
        // check for empty fields
        if (empty($_POST['customername']) || empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['phone']) || empty($_POST['address1']) || empty($_POST['address2']) || empty($_POST['city']) || empty($_POST['state']) || empty($_POST['postcode']) || empty($_POST['country']) || empty($_POST['salesrep']) || empty($_POST['creditlimit'])) {
            $output_message = '<p class="error">'.'Please fill out all the fields.</p>';
            $output_form = true;
        } else {
            $output_form = false;             
        }  // end if/else     
    } // end isset($_POST['submit'])

    // Insert header and show the navigation menu
    $page_title = 'Edit Profile';
    require_once('./includes/htmlhead.inc.php');
    require_once('./includes/navmenu.inc.php');   
?>

<?php
    if ($output_form) {
?>
    <div id="content">    
        <h2>Customer Entry Form</h2>
        <form action="<?=$_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
            <?=$output_message ?>
            <table>
                <tr>
                    <td>Customer Name:</td><td><input name="customername" type="text" value="<?=$customer_name ?>"></td>
                </tr>
                <tr>
                    <td>First Name:</td><td><input name="firstname" type="text" value="<?=$first_name ?>"></td>
                </tr>
                <tr>
                    <td>Last Name:</td><td><input name="lastname" type="text" value="<?=$last_name ?>"></td>
                </tr> 
                <tr>
                    <td>Phone:</td><td><input name="phone" type="text" value="<?=$phone ?>"></td>
                </tr>
                <tr>
                    <td>Address 1:</td><td><input name="address1" type="text" value="<?=$address1 ?>"></td>
                </tr>
                <tr>
                    <td>Address 2:</td><td><input name="address2" type="text" value="<?=$address2 ?>"></td>
                </tr>
                <tr>
                    <td>City:</td><td><input name="city" type="text" value="<?=$city ?>"></td>
                </tr>
                <tr>
                    <td>State:</td><td><input name="state" type="text" value="<?=$state ?>"></td>
                </tr>
                <tr>
                    <td>Postal Code:</td><td><input name="postcode" type="text" value="<?=$post_code ?>"></td>
                </tr>
                <tr>
                    <td>Country:</td><td><input name="country" type="text" value="<?=$country ?>"></td>
                </tr>
                <tr>
                    <td>Credit Limit:</td><td><input name="creditlimit" type="text" value="<?=$credit_limit ?>"></td>
                </tr>
                <tr>
                    <td>Sales Rep:</td><td><select name="salesrep">
                        <option value="0">Select Sales Rep</option>
                  <?php 
                      while ($row = mysqli_fetch_array($result)) {
                          $empnumber = $row['employeeNumber'];
                          $empname = $row['lastName'].', '. $row['firstName'];
                          if ($sales_rep == $empnumber) $selected = "selected";
                          else $selected = "";  
                  ?>
                        <option <?=$selected ?> value="<?=$empnumber ?>"><?=$empname ?></option>
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
    //insert the data into the database
    $query = "INSERT INTO customers (customerName, contactLastName, contactFirstName, phone, addressLine1, addressLine2, city, state, postalCode, country, salesRepEmployeeNumber, creditLimit)
          VALUES (
             '$customer_name',
             '$first_name',
             '$last_name',
             '$phone',
             '$address1',
             '$address2',
             '$city',
             '$state',
             '$post_code',
             '$country',
             '$sales_rep',
             '$credit_limit'
          )"; 
    $result = mysqli_query($dbc, $query);  
?>
        <h2>Thank you for editing your profile!</h2>
        <p>
            Name: <?=$first_name.' '.$last_name ?><br>
            Phone: <?=$phone ?><br>
            Address 1: <?=$address1 ?><br>
            Address 2: <?=$address2 ?><br>
            City: <?=$city ?><br>
            State: <?=$state ?><br>
            Postal Code: <?=$post_code ?><br>
            Country: <?=$country ?><br>
            Credit Limit: <?=$credit_limit ?><br>
        </p>

<?php
    }  // end if/else
?>

<?php
  // Insert the page footer
  require_once('./includes/footer.inc.php');
  mysqli_close($dbc);
?>
