<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email address!";
        header("Location: forgot_password.php");
        exit;
    }

    $email = mysqli_real_escape_string($conn, $email);
    $reset_code = bin2hex(random_bytes(32)); // Secure token
    $expiry_time = date("Y-m-d H:i:s", strtotime("+1 hour")); // Expires in 1 hour

    // Update user with reset token
    $query = "UPDATE users SET reset_token=?, reset_expiry=? WHERE email=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sss", $reset_code, $expiry_time, $email);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        // Send email
        $subject = "Reset Your Password";
        $message = "Click this link to reset your password: http://app.leapbroad.com/reset-password.php?code=$reset_code";
        $headers = "From: no-reply@leapbroad.com\r\n";
        mail($email, $subject, $message, $headers);

        $_SESSION['success'] = "Password reset link sent to your email.";
    } else {
        $_SESSION['error'] = "Email not found!";
    }

    mysqli_stmt_close($stmt);
    header("Location: forgot_password.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="container bg-white p-4 rounded shadow" style="max-width: 400px;">
        <h3 class="text-center mb-3">Forgot Password</h3>

        <?php if (isset($_SESSION['error'])) { ?>
            <div class='alert alert-danger'><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php } ?>
        <?php if (isset($_SESSION['success'])) { ?>
            <div class='alert alert-success'><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php } ?>

        <form method="POST" action="">
            <input type="email" name="email" class="form-control mb-2" placeholder="Enter your email" required>
            <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
        </form>

        <p class="text-center mt-3"><a href="login.php">Back to Login</a></p>
    </div>
</body>
</html>
