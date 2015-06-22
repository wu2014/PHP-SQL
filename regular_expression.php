<?php
    $output_form = 1;
    $error_text = '';

    $first_name = '';
    $last_name = '';
    $phone = '';
    $city = '';
    $state = '';
    $fname_regex = '/^([A-Z]|[a-z]){2,15}$/';
    $lname_regex = '/^([A-Z]|[a-z]){2,15}$/';
    $phone_regex = '/^\(\d{3}\)\d{3}-\d{4}$/';
    $city_regex = '/^([A-Z]|[a-z]){3,20}$/';
    $state_regex = '/^([A-Z]|[a-z]){2}$/';
    $replacement = '';
    $pattern = '/[\(\)\-\s]/';
    // use an array to include all the regular expression
    $regex = array($fname_regex, $lname_regex, $phone_regex, $city_regex, $state_regex); 

    function validate_all_regex ($regex, $input) {
        if (preg_match($regex[0], $input[0]) && preg_match($regex[1], $input[1]) && preg_match($regex[2], $input[2])
            && preg_match($regex[3], $input[3]) && preg_match($regex[4], $input[4])) {
            return true;
        } else { 
            return false;
        }
    }
   
    if (isset ($_POST['submit'])) { // data posted
    	$first_name = trim($_POST['fname']);
        $last_name = trim($_POST['lname']);
        $phone = trim($_POST['phone']);
        $city = trim($_POST['city']);
        $state = trim($_POST['state']);
        $replaced_phone = preg_replace($pattern, $replacement, $phone); 
        // use an array to include all user input
        $input = array($first_name, $last_name, $phone, $city, $state);

        if (validate_all_regex ($regex, $input)) {
            $output_form = 0;
        } else {
            if (!preg_match($regex[0], $input[0])) {
                 $error_text .= "First name must be from 2 to 15 alphabetic characters<br>\n\r";
             }
            if (!preg_match($regex[1], $input[1])) {
                $error_text .= "Last name must be from 2 to 15 alphabetic characters<br>\n\r";
            }
            if (!preg_match($regex[2], $input[2])) {
                $error_text .= "Phone number format is not correct<br>\n\r";
            }
            if (!preg_match($regex[3], $input[3])) {
                $error_text .= "City must be from 3 to 20 alphabetic characters<br>\n\r";
            }
            if (!preg_match($regex[4], $input[4])) {
                $error_text .= "State must be 2 alphabetic characters<br>\n\r";
            }
        }
    } // end if/else (isset($_POST['submit']))
    require_once("./includes/htmlhead.inc.php");    
?>    


<body>
    <div>
<?php require_once("./includes/header.inc.php"); ?>
    <div id="content">   
<?php
    if ($output_form) {
?>
    <h2>User data validation</h2>
    <p>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
        <?= $error_text ?>
	    <table>
	    	<tr>
	    		<td>First Name:</td><td><input name="fname" type="text" value="<?=$first_name ?>"></td>
	    	</tr>
	    	<tr>
	    		<td>Last Name:</td><td><input name="lname" type="text" value="<?=$last_name ?>"></td>
	    	</tr>
	    	<tr>
	    		<td>Phone (xxx)xxx-xxxx:</td><td><input name="phone" type="text" value="<?=$phone ?>"></td>
	    	</tr>
            <tr>
                <td>City:</td><td><input name="city" type="text" value="<?=$city ?>"></td>
            </tr>
            <tr>
                <td>State:</td><td><input name="state" type="text" value="<?=$state ?>"></td>
            </tr>
	    </table>
	    <input name="submit" type="submit">
	</form>
    <p>	
<?php
    } else {
    // Any additional processing
?>
        <h2>User Data Validated</h2>
        <p>Congradulations! Your user data is valid</p>
        <p>Last Name, First Name: <?=$last_name.', '.$first_name ?></p>
        <p>Phone Number: <?=$phone.', '.$replaced_phone ?></p>
        <p>City, State: <?=$city.', ' .$state ?></p>

<?php
    }  // end if/else form out
?>
    </div>
<?php require_once("./includes/footer.inc.php"); ?>
    </div>
</body>
</html>