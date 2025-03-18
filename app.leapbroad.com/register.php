<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $verification_code = bin2hex(random_bytes(32)); // Secure unique code

    // Validate username (letters, numbers, underscores only)
    if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
        $_SESSION['error'] = "Username can only contain letters, numbers, and underscores!";
        header("Location: register.php");
        exit;
    }

    // Validate password strength
    if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
        $_SESSION['error'] = "Password must be at least 8 characters long, contain an uppercase letter, a number, and a special character!";
        header("Location: register.php");
        exit;
    }

    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match!";
        header("Location: register.php");
        exit;
    }

    // Check if username or email already exists
    $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE username=? OR email=?");
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    
    if (mysqli_stmt_num_rows($stmt) > 0) {
        $_SESSION['error'] = "Username or Email already exists!";
        header("Location: register.php");
        exit;
    }
    mysqli_stmt_close($stmt);

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Insert user into the database
    $query = "INSERT INTO users (first_name, last_name, username, email, password, verification_code, verified) VALUES (?, ?, ?, ?, ?, ?, 0)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssss", $first_name, $last_name, $username, $email, $hashed_password, $verification_code);
    
    if (mysqli_stmt_execute($stmt)) {
        // Send verification email
        $subject = "Verify Your Email";
        $message = "Click this link to verify your email: http://app.leapbroad.com/verify.php?code=$verification_code";
        $headers = "From: no-reply@leapbroad.com\r\n";
        mail($email, $subject, $message, $headers);

        $_SESSION['success'] = "Registration successful! Check your email to verify your account.";
        header("Location: login.php");
        exit;
    } else {
        $_SESSION['error'] = "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="container bg-white p-4 rounded shadow" style="max-width: 400px;">
        <h3 class="text-center mb-3">Register</h3>
        
        <?php if (isset($_SESSION['error'])) { ?>
            <div class='alert alert-danger'><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php } ?>
        <?php if (isset($_SESSION['success'])) { ?>
            <div class='alert alert-success'><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php } ?>

        <form method="POST" action="">
            <input type="text" name="first_name" class="form-control mb-2" placeholder="First Name" required>
            <input type="text" name="last_name" class="form-control mb-2" placeholder="Last Name" required>
            <input type="text" name="username" class="form-control mb-2" placeholder="Username" required>
            <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
            <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
            <input type="password" name="confirm_password" class="form-control mb-2" placeholder="Confirm Password" required>
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
        
        <p class="text-center mt-3"><a href="login.php">Already have an account? Login</a></p>
    </div>
</body>
</html>
