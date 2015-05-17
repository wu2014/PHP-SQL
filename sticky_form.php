<?php 
    $output_form = true;
    $output_message = "";
    $fname = "";
    $lname = "";
    $address = "";
    $city = "";
    $state = "";
    $zip_code = "";

    if (isset ($_POST['submit'])) { // data submitted
    	$fname = trim($_POST['fname']);
        $lname = trim($_POST['lname']);
        $address = trim($_POST['address']);
        $city = trim($_POST['city']);
        $state = trim($_POST['state']);
        $zip_code = trim($_POST['zipcode']);
        // check for empty fields
        if (empty($_POST['fname']) || empty($_POST['lname']) || empty($_POST['address']) || empty($_POST['city']) || empty($_POST['state']) || empty($_POST['zipcode'])) {  
            $output_message = "<p><strong>Please fill out the empty field.</strong></p>\n";
            $output_form = true;
        } else {
        	$output_form = false;
        }    
    } // end if/else  
?>    

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Lesson 3</title>
</head>	
<body>
<?php
    if ($output_form) {
?>
    <h1>HTML Forms</h1>
    <h2>Customer Entry Form</h2>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
        <?=$output_message?>
        <table>
            <tr>
                <td>First Name:</td>
                <td><input name="fname" type="text" value="<?=$fname?>"></td>
            </tr>
            <tr>
                <td>Last Name:</td>
                <td><input name="lname" type="text" value="<?=$lname?>"></td>
            </tr>
            <tr>
                <td>Street Address:</td>
                <td><input name="address" type="text" value="<?=$address?>"></td>
            </tr>
            <tr>
                <td>City:</td>
                <td><input name="city" type="text" value="<?=$city?>"></td>
            </tr>
            <tr>
                <td>State:</td>
                <td><input name="state" type="text" value="<?=$state?>"></td>
            </tr>
            <tr>
                <td>Zip Code:</td>
                <td><input name="zipcode" type="text" value="<?=$zip_code?>"></td>
            </tr>
        </table>
        <input name="submit" type="submit">
    </form>
<?php
    } else {           
?>
    <p>
        Name: <?=$fname.' '.$lname?><br>
        Street Address: <?=$address?><br>
        City, State zip code: <?=$city.', '.$state.' '.$zip_code?>         
    </p>
<?php
    }  // end if/else
?>   
</body>
</html>