<?php
session_start();
include 'db.php'; // Include database connection file

// Disable error reporting for production
if ($_SERVER['SERVER_NAME'] !== 'localhost') {
    error_reporting(0);
    ini_set('display_errors', 0);
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

// Regenerate session ID on every request to prevent session fixation attacks
session_regenerate_id(true);

// Input sanitization function
function sanitizeInput($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

// Password hashing and verification
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}

// CSRF Token Generation and Validation
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));  // Generate CSRF token if not set
}

function validateCSRF($token) {
    return isset($_SESSION['csrf_token']) && $_SESSION['csrf_token'] === $token;
}

// Prevent SQL Injection with Prepared Statements
function getUserByUsernameOrEmail($conn, $loginInput) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE (username = ? OR email = ?) AND verified = 1");
    $stmt->bind_param('ss', $loginInput, $loginInput);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Secure session cookie settings
ini_set('session.cookie_secure', 1);  // Ensure cookies are only sent over HTTPS
ini_set('session.cookie_httponly', 1); // Prevent JavaScript access to session cookies

// Handle login submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['login'])) {
    // Sanitize user inputs
    $loginInput = sanitizeInput($_POST['login']);
    $password = sanitizeInput($_POST['password']);
    $csrfToken = $_POST['csrf_token'];

    // CSRF Protection
    if (!validateCSRF($csrfToken)) {
        die("Invalid CSRF token.");
    }

    // Validate input
    if (empty($loginInput) || empty($password)) {
        $_SESSION['error'] = "Username/Email and Password are required!";
        header("Location: login.php");
        exit;
    }

    // Check user credentials
    $user = getUserByUsernameOrEmail($conn, $loginInput);

    if ($user && verifyPassword($password, $user['password'])) {
        // Login successful, set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Redirect to dashboard
        header("Location: dashboard.php");
        exit;
    } else {
        $_SESSION['error'] = "Invalid login credentials or email not verified!";
        header("Location: login.php");
        exit;
    }
}

// Handle password change
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['change_password'])) {
    $newPassword = sanitizeInput($_POST['new_password']);
    $confirmPassword = sanitizeInput($_POST['confirm_password']);
    $csrfToken = $_POST['csrf_token'];

    // CSRF Protection
    if (!validateCSRF($csrfToken)) {
        die("Invalid CSRF token.");
    }

    // Validate password fields
    if (empty($newPassword) || empty($confirmPassword)) {
        $_SESSION['error'] = "Password fields are required!";
        header("Location: change_password.php");
        exit;
    }

    if ($newPassword !== $confirmPassword) {
        $_SESSION['error'] = "Passwords do not match!";
        header("Location: change_password.php");
        exit;
    }

    // Hash new password and update in database
    $user_id = $_SESSION['user_id'];
    $newHashedPassword = hashPassword($newPassword);

    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->bind_param('si', $newHashedPassword, $user_id);
    if ($stmt->execute()) {
        $_SESSION['success'] = "Password changed successfully!";
        header("Location: dashboard.php");
        exit;
    } else {
        $_SESSION['error'] = "Failed to change password!";
        header("Location: change_password.php");
        exit;
    }
}

// Handle file uploads securely
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['upload'])) {
    $allowedTypes = ['image/jpeg', 'image/png'];
    $fileType = $_FILES['upload']['type'];

    // Validate file type
    if (!in_array($fileType, $allowedTypes)) {
        die("Invalid file type. Only JPEG and PNG are allowed.");
    }

    // Validate file size (e.g., max 2MB)
    if ($_FILES['upload']['size'] > 2 * 1024 * 1024) {
        die("File size exceeds the limit of 2MB.");
    }

    // Generate a unique file name to avoid overwriting
    $targetDir = "uploads/";
    $fileName = uniqid() . "_" . basename($_FILES['upload']['name']);
    $targetFile = $targetDir . $fileName;

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES['upload']['tmp_name'], $targetFile)) {
        echo "File uploaded successfully!";
    } else {
        echo "Error uploading file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Site</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Secure Site</a>
            <div class="d-flex align-items-center">
                <div class="dropdown mx-2">
                    <button class="btn btn-outline-secondary" type="button" id="notificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-bell"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="notificationsDropdown">
                        <li><a class="dropdown-item" href="#">New comment on your post</a></li>
                        <li><a class="dropdown-item" href="#">New like on your photo</a></li>
                        <li><a class="dropdown-item" href="#">Your password has been changed</a></li>
                    </ul>
                </div>

                <div class="dropdown">
                    <button class="btn btn-outline-secondary" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="profile_icon.png" alt="Profile" class="rounded-circle" width="30" height="30">
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                        <li><a class="dropdown-item" href="edit_profile.php">Edit Profile</a></li>
                        <li><a class="dropdown-item" href="change_password.php">Change Password</a></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5 pt-5">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>

        <!-- Display success/error messages -->
        <?php if (isset($_SESSION['error'])) { ?>
            <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php } ?>
        <?php if (isset($_SESSION['success'])) { ?>
            <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php } ?>
        
        <!-- Profile Form -->
        <form action="secure_site.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <label for="upload">Upload File:</label>
            <input type="file" name="upload" id="upload">
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
