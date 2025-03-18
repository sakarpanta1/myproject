<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Get user details
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id='$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = trim($_POST['current_password']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validate input
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $_SESSION['error'] = "All fields are required!";
        header("Location: change_password.php");
        exit;
    }

    // Check if the current password is correct
    if (!password_verify($current_password, $user['password'])) {
        $_SESSION['error'] = "Current password is incorrect!";
        header("Location: change_password.php");
        exit;
    }

    // Validate new password strength (optional)
    if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $new_password)) {
        $_SESSION['error'] = "New password must contain at least 8 characters, 1 uppercase letter, 1 number, and 1 special character!";
        header("Location: change_password.php");
        exit;
    }

    // Check if new password and confirm password match
    if ($new_password !== $confirm_password) {
        $_SESSION['error'] = "New password and confirm password do not match!";
        header("Location: change_password.php");
        exit;
    }

    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update password in the database
    $update_query = "UPDATE users SET password=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt, "si", $hashed_password, $user_id);
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "Password changed successfully!";
    } else {
        $_SESSION['error'] = "Error updating password: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);

    header("Location: change_password.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="d-flex justify-content-center align-items-center vh-100 bg-light">
    <div class="container bg-white p-4 rounded shadow" style="max-width: 400px;">
        <h3 class="text-center mb-3">Change Password</h3>

        <!-- Display error or success messages -->
        <?php if (isset($_SESSION['error'])) { ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php } ?>
        <?php if (isset($_SESSION['success'])) { ?>
            <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php } ?>

        <form method="POST">
            <input type="password" name="current_password" class="form-control mb-2" placeholder="Current Password" required>
            <input type="password" name="new_password" class="form-control mb-2" placeholder="New Password" required>
            <input type="password" name="confirm_password" class="form-control mb-2" placeholder="Confirm New Password" required>
            <button type="submit" class="btn btn-primary w-100">Change Password</button>
        </form>

        <p class="text-center mt-3"><a href="dashboard.php" class="text-decoration-none">Back to Dashboard</a></p>
    </div>
</body>
</html>
