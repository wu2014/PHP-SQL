<?php 
    $output_form = true;
    $error_message = "";
    $welcome_message = "Hello, welcome ";
    $fname = "";
    $number = "";
    $sentence = "";
     
    // concatenate name and welcome message 
    function concatenate_name($fname, $welcome_message) {
        if (empty($fname)) {
            return false;
        } else {
            return $welcome_message. $fname;
        }
    }
    
    // verify the input number and calculate the square root and the number cubed
    function verify_number($number) {
        if ($number > 200 || $number < 100) {
            return false;
        } else { 
            $return_number = array(sqrt($number), pow($number, 3));
            return implode(",", $return_number);
        }
    }
    
    // If at least 20 characters, return the last 9 characters
    function check_sentence($sentence) {
        $length = strlen($sentence);
        if ($length < 20) {
            return false;
        } else { 
            return substr($sentence, ($length-9));
        }
    }


    if (isset ($_POST['submit'])) { // data submitted
    	$fname = trim($_POST['fname']);
        $number = trim($_POST['number']);
        $sentence = trim($_POST['sentence']);
    
        // check for each field and indicate the error if it was false
        if (!concatenate_name($fname, $welcome_message)) {  
            $error_message = "<p class='error'>The user name can not be empty.</p>\n";
            $output_form = true;
        } else if (!verify_number($number)){
            $error_message = "<p class='error'>The number should be between 100 and 200.</p>\n";
            $output_form = true;
        } else if (!check_sentence($sentence)) {
            $error_message = "<p class='error'>The sentence should be at least 20 characters.</p>\n";
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
	<title>Lesson 6</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>	
<body>
<?php
    if ($output_form) {
?>
    <h1>HTML Forms</h1>
    <h2>Customer Entry Form</h2>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
        <?=$error_message?>
        <table>
            <tr>
                <td>First Name:</td>
                <td><input name="fname" type="text" value="<?=$fname?>"></td>
            </tr>
            <tr>
                <td>Number:</td>
                <td><input name="number" type="text" value="<?=$number?>"></td>
            </tr>
            <tr>
                <td>Sentence:</td>
                <td><input name="sentence" type="text" value="<?=$sentence?>"></td>
            </tr>
        </table>
        <input name="submit" type="submit">
    </form>
<?php
    } else {           
?>
    <p>
        <?=concatenate_name($fname, $welcome_message)?><br>
        <?='The square root and cubed of '.$number.' are '. verify_number($number)?><br>
        <?='The last 9 characters of the sentence are '.check_sentence($sentence)?>         
    </p>
<?php
    } // end if/else
?>   
</body>
</html>