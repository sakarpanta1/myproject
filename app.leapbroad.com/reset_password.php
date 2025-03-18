<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reset_code = $_POST['reset_code'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match!";
        header("Location: reset-password.php?code=$reset_code");
        exit;
    }

    if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $new_password)) {
        $_SESSION['error'] = "Password must be at least 8 characters, include an uppercase letter, a number, and a special character!";
        header("Location: reset-password.php?code=$reset_code");
        exit;
    }

    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

    // Validate reset code and expiry
    $stmt = mysqli_prepare($conn, "SELECT email FROM users WHERE reset_token=? AND reset_expiry > NOW()");
    mysqli_stmt_bind_param($stmt, "s", $reset_code);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_bind_result($stmt, $email);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        // Update password
        $update_stmt = mysqli_prepare($conn, "UPDATE users SET password=?, reset_token=NULL, reset_expiry=NULL WHERE email=?");
        mysqli_stmt_bind_param($update_stmt, "ss", $hashed_password, $email);
        mysqli_stmt_execute($update_stmt);
        mysqli_stmt_close($update_stmt);

        $_SESSION['success'] = "Your password has been updated. Please log in.";
        header("Location: login.php");
        exit;
    } else {
        $_SESSION['error'] = "Invalid or expired reset link!";
        header("Location: forgot_password.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="container bg-white p-4 rounded shadow" style="max-width: 400px;">
        <h3 class="text-center mb-3">Reset Password</h3>

        <?php if (isset($_SESSION['error'])) { ?>
            <div class='alert alert-danger'><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php } ?>
        <?php if (isset($_SESSION['success'])) { ?>
            <div class='alert alert-success'><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php } ?>

        <form method="POST" action="">
            <input type="hidden" name="reset_code" value="<?php echo $_GET['code']; ?>">
            <input type="password" name="new_password" class="form-control mb-2" placeholder="New Password" required>
            <input type="password" name="confirm_password" class="form-control mb-2" placeholder="Confirm Password" required>
            <button type="submit" class="btn btn-primary w-100">Reset Password</button>
        </form>
        
        <p class="text-center mt-3"><a href="login.php">Back to Login</a></p>
    </div>
</body>
</html>
