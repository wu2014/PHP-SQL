<?php
    session_start();

    // If the session vars aren't set, try to set them with a cookie
    if (!isset($_SESSION['customerNumber'])) {
        if (isset($_COOKIE['customerNumber']) && isset($_COOKIE['username'])) {
            $_SESSION['customerNumber'] = $_COOKIE['customerNumber'];
            $_SESSION['username'] = $_COOKIE['username'];
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lesson 5</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h3>Lesson 5</h3>

<?php 
    // Generate the navigation menu
    if (isset($_SESSION['username'])) {
        echo '<a href="logout.php">Log Out (' . $_SESSION['username'] . ')</a>';
    } else {
        echo '<a href="login.php">Log In</a><br>';
        echo '<a href="signup.php">Sign Up</a>';
    }
?>
</body> 
</html>
