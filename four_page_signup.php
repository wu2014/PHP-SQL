<?php   
    // Connect to the database
    require_once('./includes/connectvars.inc.php');

    // First display the blank form
    $fname = "";
    $lname = "";
    $email = "";
    $username = "";
    $password1 = "";
    $password2 = "";
    $output_form = true;
    $output_message = "";

    // Connect to the database
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if (isset($_POST['submit'])) {
        // Grab the profile data from the POST
        $fname = mysqli_real_escape_string($dbc, trim($_POST['fname']));
        $lname = mysqli_real_escape_string($dbc, trim($_POST['lname']));
        $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
        $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
        $password1 = mysqli_real_escape_string($dbc, trim($_POST['password1']));
        $password2 = mysqli_real_escape_string($dbc, trim($_POST['password2']));

        // Make sure the aboved fields are not empty and password1 is euqal to password2 
        if (!empty($fname) && !empty($lname) && !empty($email) && !empty($username) && !empty($password1) && !empty($password2) && ($password1 == $password2)) {
            // Make sure someone has not already registered using this username
            $query = "SELECT * FROM employee WHERE username = '$username'";
            $data = mysqli_query($dbc, $query);
            if (mysqli_num_rows($data) == 0) {
                // The username is unique
                $output_form = false;
            } else {
                // This username has already used by other account, so display an error message
                $output_form = true;
                $output_message = '<p class="error">'.'This username has already used by other account. Please choose a different user name.</p>';
                $username = "";    
            }
        } else {
            $output_form = true;
            $output_message = '<p class="error">You must enter all of the sign-up fields, including the same password twice.</p>';
        }
    }
    // insert header and navigation links
    $page_title = 'Sign Up';
    require_once("./includes/htmlhead.inc.php");
    require_once('./includes/navmenu.inc.php');  
?>

<?php
    if ($output_form) {
?>   

    <div id="content">  
        <h2>Customer Sign Up Form</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <?=$output_message ?>
            <table>
                <tr>
                    <td>First Name:</td>
                    <td><input name="fname" type="text" value="<?=$fname ?>"></td>
                </tr>
                <tr>
                    <td>Last Name:</td>
                    <td><input name="lname" type="text" value="<?=$lname ?>"></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><input name="email" type="text" value="<?=$email ?>"></td>
                </tr>
                <tr>
                    <td>Username:</td>
                    <td><input name="username" type="text"  value="<?=$username ?>"></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input name="password1" type="password"></td>
                </tr>
                <tr>
                    <td>Password (retype):</td>
                    <td><input name="password2" type="password"></td>
                </tr>
            </table>       
            <input type="submit" value="Sign Up" name="submit">
        </form>
    </div>
<?php
    } else {
    // insert the data into the database   
    $query = "INSERT INTO employee (username, password, firstName, lastName, email) VALUES ('$username', MD5('$password1'), '$fname', '$lname', '$email')";
    $result = mysqli_query($dbc, $query);
?>   
    <p>Congratulations. Your account has been successfully created.</p>
    <p>You're now ready to <a href="login.php">log in</a>.</p>
    <img src="./images/car.gif" alt="Car Icon"> 

<?php
    }  // end if/else
?>

<?php 
require_once('./includes/footer.inc.php'); 
mysqli_close($dbc);
?>
    
