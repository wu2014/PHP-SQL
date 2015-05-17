<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lesson 5</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h3>Lesson 5 - Sign Up</h3>

<?php
    require_once('connectvars.php');

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
            $query = "SELECT * FROM customers WHERE username = '$username'";
            $data = mysqli_query($dbc, $query);
            if (mysqli_num_rows($data) == 0) {
                // The username is unique, so insert the data into the database
                $query = "INSERT INTO customers (username, password, contactFirstName, contactLastName, email) VALUES ('$username', MD5('$password1'), '$fname', '$lname', '$email')";
                mysqli_query($dbc, $query);

               // Confirm success with the user
                echo '<p>Congratulations. Your account has been successfully created. You\'re now ready to <a href="login.php">log in</a>.</p>';

                mysqli_close($dbc);
                exit();
            } else {
                // This username has already used by other account, so display an error message
                echo '<p class="error">This username has already used by other account. Please choose a different user name.</p>';
                $username = "";
            }
        } else {
            echo '<p class="error">You must enter all of the sign-up fields, including the same password twice.</p>';
        }
    }

    mysqli_close($dbc);
?>

    <p>Please enter your username and password to sign up lesson 5.</p>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <fieldset>
            <legend>Registration Info</legend>
            <label for="fname">First Name:</label>
            <input type="text" id="fname" name="fname" value="<?php if (!empty($fname)) echo $fname; ?>"><br>
            <label for="lname">Last Name:</label>
            <input type="text" id="lname" name="lname" value="<?php if (!empty($lname)) echo $lname; ?>"><br>
            <label for="lname">Email:</label>
            <input type="text" id="email" name="email" value="<?php if (!empty($email)) echo $email; ?>"><br>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php if (!empty($username)) echo $username; ?>"><br>
            <label for="password1">Password:</label>
            <input type="password" id="password1" name="password1"><br>
            <label for="password2">Password (retype):</label>
            <input type="password" id="password2" name="password2"><br>
        </fieldset>
            <input type="submit" value="Sign Up" name="submit">
    </form>
</body> 
</html>
