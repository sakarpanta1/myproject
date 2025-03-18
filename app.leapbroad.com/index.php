<?php
// Start session
session_start();

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    // Redirect logged-in users to the dashboard or home page
    header('Location: dashboard.php'); // or any other page
    exit();
} else {
    // Redirect to the login page if the user is not logged in
    header('Location: login.php');
    exit();
}
?>
