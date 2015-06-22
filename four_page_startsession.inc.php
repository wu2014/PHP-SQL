<?php
    session_start();

    // If the session vars aren't set, try to set them with a cookie
    if (!isset($_SESSION['employeeNumber'])) {
        if (isset($_COOKIE['employeeNumber']) && isset($_COOKIE['username'])) {
            $_SESSION['employeeNumber'] = $_COOKIE['employeeNumber'];
            $_SESSION['username'] = $_COOKIE['username'];
        }
    }
?>
