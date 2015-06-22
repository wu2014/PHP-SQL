<?php
    $output_form = 1;
    $error_text = '';

    $user_string = '';
    $ustring_regex = '/^[a-zA-Z0-9\$^@]{5}$/';
    $ustring_error_message = 'Your string must be A-Z,a-z, 0-9, $, ^ and @';

    if (isset ($_POST['submit'])) { // data posted

    	$user_string = trim($_POST['userString']);
        
        // validate first string
        if (preg_match($ustring_regex, $user_string)) {
            $output_form = 0;
        } else {
            $error_text .= "<p class='error'>$ustring_error_message</p>\n\r";
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
    <p>Please enter a five character string (Only allowed A-Z,a-z,0-9, $, ^ and @).</p>
    <p>We'll create a graphic based on your string.</p>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
        <?= $error_text ?>
	    <table>
	    	<tr>
	    		<td>Your string:</td><td><input name="userString" type="text" value="<?=$user_string ?>"></td>
	    	</tr>
	    </table>
	    <input name="submit" type="submit">
	</form>
    
<?php
    } else {   
?>
        <h2>User is validated</h2>
        <p>Your string CAPTCHA style is <br><img src="./string_image.php?ustring=<?=$user_string ?>" alt="user image string"></p>
        <p><a href="<?= $_SERVER['PHP_SELF'] ?>">Play Again</a></p>
   
<?php
// Any additional processing into database, and send comfirmation email, etc..
    }  // end if/else form out
?>

    </div>
<?php require_once("./includes/footer.inc.php"); ?>
    </div>
</body>
</html>
