<?php
// site variables include
// account file path
    // site root path for PHP
    define ("SITE_ROOT_PATH", $_SERVER["DOCUMENT_ROOT"]);
    // HTML upload path
    define("USER_UPLOAD_DIR", "/uploads/");
    // file upload size in bytes*kilobyte
    define("MAX_UPLOAD_SIZE", 50*1024);  

    $output_form = 1;
    $error_text = "";
    $correct_image_type = false;
    $file_upload_size = false;

    $photo_types = array("image/gif", "image/jpg", "image/jpeg", "image/png");

    $fname = "";
    $lname = "";
    $user_file = "";

    if (isset ($_POST['submit'])) { // data posted
    	$fname = trim($_POST['fname']);
        $lname = trim($_POST['lname']);
        $user_file = $_FILES['userphoto']['name'];
        $file_type = $_FILES['userphoto']['type'];
        $file_size = $_FILES['userphoto']['size'];
        $file_tmp_name = $_FILES['userphoto']['tmp_name'];
        $upload_error = $_FILES['userphoto']['error'];

        if ($file_size == 0 || $file_size > MAX_UPLOAD_SIZE) {   
            $file_upload_size = false;
            $error_text .= "<p>Images must less than 50kb</p>";
        } else {$file_upload_size = true;}
        if (!in_array($file_type, $photo_types)) {
            $correct_image_type = false;
            $error_text .= "<p>Images must be .gif, .jpg, or .png</p>";    
        } else {$correct_image_type = true;}
        // check for empty fields and proper file upload information
        if (empty($_POST['fname']) ||
            empty($_POST['lname']) ||
            $_FILES['userphoto']['error'] != 0 ||
            !$file_upload_size ||
            !$correct_image_type) {
            $error_text .= "<p>All fields are manditory.</p>\n";
            $output_form = 1;
        } else {
            $output_form = 0;
            // move file upload to our directory
            $target_file = SITE_ROOT_PATH. USER_UPLOAD_DIR. $user_file;
            // check for existing file name
            !file_exists($target_file)
                or die("file name already exists");
            move_uploaded_file($file_tmp_name, $target_file)
                or die ("file move failed");    
        } // end if/else final checks
    } // end if/else (isset($_POST['submit'])) 
?>    

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lesson 4</title>
</head> 
<body> 
<?php
    if ($output_form) {
?>
    <h2>User uploads Photo </h2>
    <form action="<?= $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
        <?= $error_text ?>
	    <table>
	    	<tr>
	    		<td>First Name:</td><td><input name="fname" type="text" value="<?=$fname?>"></td>
	    	</tr>
	    	<tr>
	    		<td>Last Name:</td><td><input name="lname" type="text" value="<?=$lname?>"></td>
	    	</tr>
	    	<tr>
	    		<td>User Photo (50kb limit):<br>.gif, .jpg, .png only</td><td><input name="userphoto" type="file"></td>
	    	</tr>
	    </table>
	    <input name="submit" type="submit">
	</form>	
<?php
    } else {
    // send comfirmation email
?>
        <h2>Thank you for uploading a photo!</h2>
        <p>Name: <?= $fname.' '.$lname ?></p>
        <p><img src="<?=USER_UPLOAD_DIR.$user_file ?>"></p>
<?php
    } // end if/else form out
?>        
</body>
</html>


	