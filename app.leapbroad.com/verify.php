<?php
session_start();
include 'db.php';

if (isset($_GET['code'])) {
    $code = $_GET['code'];
    $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE verification_code=? AND verified=0");
    mysqli_stmt_bind_param($stmt, "s", $code);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    
    if (mysqli_stmt_num_rows($stmt) > 0) {
        // Verify user
        $update_stmt = mysqli_prepare($conn, "UPDATE users SET verified=1, verification_code=NULL WHERE verification_code=?");
        mysqli_stmt_bind_param($update_stmt, "s", $code);
        mysqli_stmt_execute($update_stmt);
        mysqli_stmt_close($update_stmt);

        $_SESSION['success'] = "Your email has been verified! You can now log in.";
    } else {
        $_SESSION['error'] = "Invalid or expired verification link!";
    }
    
    mysqli_stmt_close($stmt);
    header("Location: login.php");
    exit;
}
?>
