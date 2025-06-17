<?php
session_start();
// Tell browser this is JavaScript
header('Content-Type: application/javascript');

// If user is not logged in, redirect to login page
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo "window.location.href = '/login.html';";
}
?>
