<?php
    // If the user is logged in, delete the session vars to log them out
    require_once('./includes/startsession.inc.php');
    if (isset($_SESSION['employeeNumber'])) {
        // Delete the session vars by clearing the $_SESSION array
        $_SESSION = array();

        // Delete the session cookie by setting its expiration to an hour ago (3600)
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600);
        }

        // Destroy the session
        session_destroy();
    }

    // Delete the user ID and username cookies by setting their expirations to an hour ago (3600)
    setcookie('employeeNumber', '', time() - 3600);
    setcookie('username', '', time() - 3600);
    echo 'You have been sucessfully logged out, Goodbye.';
    // Redirect to the home page after 8 sec
    $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
    header('Refresh: 8;' . $home_url);
?>
