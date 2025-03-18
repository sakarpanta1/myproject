<?php
session_start();
include 'db.php';

// Handle login submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $loginInput = trim($_POST['login']);
    $password = trim($_POST['password']);
    $rememberMe = isset($_POST['rememberMe']);

    // Validate input
    if (empty($loginInput) || empty($password)) {
        $_SESSION['error'] = "Username/Email and Password are required!";
        header("Location: login.php");
        exit;
    }

    $loginInput = mysqli_real_escape_string($conn, $loginInput);

    // Query to check either username or email
    $query = "SELECT id, username, email, password FROM users WHERE (username=? OR email=?) AND verified=1";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $loginInput, $loginInput);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    // Verify password
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Set secure Remember Me token
        if ($rememberMe) {
            $token = bin2hex(random_bytes(32));
            $expiry = time() + (86400 * 30); // 30 days

            // Store token in database
            $storeToken = "UPDATE users SET remember_token=? WHERE id=?";
            $tokenStmt = mysqli_prepare($conn, $storeToken);
            mysqli_stmt_bind_param($tokenStmt, "si", $token, $user['id']);
            mysqli_stmt_execute($tokenStmt);
            mysqli_stmt_close($tokenStmt);

            setcookie("remember_token", $token, $expiry, "/", "", true, true); // Secure cookie
        }

        // Redirect to dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        $_SESSION['error'] = "Invalid login credentials or email not verified!";
        header("Location: login.php");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="container bg-white p-4 rounded shadow" style="max-width: 400px;">
        <h3 class="text-center mb-3">Login</h3>

        <!-- Display error message -->
        <?php if (isset($_SESSION['error'])) { ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php } ?>

        <form method="POST">
            <input type="text" name="login" class="form-control mb-2" placeholder="Username or Email" required>
            <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="rememberMe" name="rememberMe">
                <label class="form-check-label" for="rememberMe">Remember Me</label>
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>

            <div class="d-flex justify-content-between mt-3">
                <a href="forgot_password.php" class="text-decoration-none">Forgot Password?</a>
                <a href="register.php" class="text-decoration-none">Register</a>
            </div>
        </form>
    </div>
</body>
</html>
