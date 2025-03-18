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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css"> <!-- Custom Styles -->
    <style>
        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #343a40;
            color: white;
            padding-top: 20px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
        }

        .sidebar a:hover {
            background-color: #007bff;
        }

        .main-content {
            margin-left: 250px;
            padding-top: 20px;
        }

        /* Navbar and Profile/Notification styles */
        .navbar {
            z-index: 100;
            padding: 10px 20px;
        }

        .navbar-brand img {
            width: 40px;
            height: auto;
            margin-right: 10px;
        }

        .navbar .navbar-nav {
            margin-left: auto;
            display: flex;
            align-items: center;
        }

        /* Notification and Profile button styles */
        .dropdown-menu {
            min-width: 250px;
            padding: 5px 0;
        }

        .dropdown-menu .dropdown-item {
            padding: 10px 20px;
        }

        .dropdown-item:hover {
            background-color: #007bff;
            color: white;
        }

        /* Profile dropdown styles */
        .dropdown-menu-end {
            right: 0;
            left: auto;
        }

        .dropdown-toggle::after {
            display: none;
        }

        .btn-outline-secondary {
            display: flex;
            align-items: center;
        }

        .btn-outline-secondary img {
            width: 30px;
            height: 30px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center text-white">Admin Dashboard</h4>
        <a href="#" id="addStudent">Add Student</a>
        <a href="#" id="searchCourse">Search Course</a>
        <a href="#" id="myStudents">My Students</a>
        <a href="#" id="applications">Applications</a>
        <a href="#" id="enrollment">Enrollment</a>
        <a href="#" id="institutions">Institutions</a>
        <a href="#" id="manageUsers">Manage Users</a>
        <a href="#" id="commissionHub">Commission Hub</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="uploads/logo.png" alt="Logo"> Dashboard
                </a>
                <div class="navbar-nav ms-auto d-flex align-items-center">
                    <!-- Notification Dropdown -->
                    <div class="dropdown mx-2">
                        <button class="btn btn-outline-secondary" type="button" id="notificationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-bell" style="font-size: 20px;"></i> <!-- Bootstrap icon for bell -->
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="notificationsDropdown">
                            <li><a class="dropdown-item" href="#">New comment on your post</a></li>
                            <li><a class="dropdown-item" href="#">New like on your photo</a></li>
                            <li><a class="dropdown-item" href="#">Your password has been changed</a></li>
                        </ul>
                    </div>

                    <!-- Profile Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary" type="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="profile_icon.png" alt="Profile" class="rounded-circle" width="30" height="30"> <!-- Profile Image -->
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

        <div class="container mt-5 pt-5">
            <h2 class="my-4">Welcome, <?php echo htmlspecialchars($user['first_name']); ?>!</h2>
            <p>Here is your dashboard where you can view and manage your details.</p>

            <!-- Your Dashboard Content -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">User Overview</h5>
                    <p class="card-text">You can access your account settings from the profile dropdown in the top right corner.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="assets/js/script.js"></script> <!-- Custom JS -->
</body>
</html>
