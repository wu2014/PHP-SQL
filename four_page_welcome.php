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

    // if log in, welcome the user
    if (isset($_SESSION['username'])) {
        echo 'Welcome'.' ' .$_SESSION['username'].'<br>';
        echo '<a href="logout.php">Log Out (' . $_SESSION['username'] . ')</a>';
    }
?>
</body> 
</html>
