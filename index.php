<?php
// Force HTTPS
if ($_SERVER['HTTPS'] !== 'on') {
    $redirectUrl = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("Location: " . $redirectUrl);
    exit();
}

session_start(); // Start session (though this may not be needed now)
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

$allowedPages = [
    'home', 'about', 'institutions', 'studydestinations', 'career', 'news', 'login', 'register',
    'our-company', 'vision-mission', 'our-team', 'privacy-policy'
];

if (!in_array($page, $allowedPages)) {
    $page = 'home';
}

$pageFile = $page . '.php';

// No security checks for file inclusion anymore
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ucfirst($page); ?> | Your Website</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <!-- Preload important resources -->
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" as="style">
    <link rel="preload" href="assets/css/style.css" as="style">
</head>
<body>
   <header class="bg-light py-3 shadow-sm">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php"><?php include 'logo.php'; ?></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="aboutDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                About Sakar Panta
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="aboutDropdown">
                                <li><a class="dropdown-item" href="index.php?page=our-company">Our Company</a></li>
                                <li><a class="dropdown-item" href="index.php?page=vision-mission">Vision and Mission</a></li>
                                <li><a class="dropdown-item" href="index.php?page=our-team">Our Team</a></li>
                                <li><a class="dropdown-item" href="index.php?page=privacy-policy">Privacy Policy</a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="index.php?page=institutions">Institutions</a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?page=studydestinations">Study Destinations</a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?page=career">Career</a></li>
                        <li class="nav-item"><a class="nav-link" href="index.php?page=news">News</a></li>
                    </ul>
                    <div class="d-flex mt-2 mt-lg-0">
                        <a href="index.php?showModal=login" class="btn btn-outline-primary me-2">Login</a>
                        <a href="index.php?showModal=register" class="btn btn-primary">Register</a>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>

    </header>

    <section class="hero">
        <?php if ($page === 'home') include 'cover.php'; ?>
    </section>

    <main class="container my-5">
        <?php
        // Directly include the page file if it exists
        if (file_exists($pageFile)) {
            include $pageFile;
        }

        // Include additional elements on the home page
        if ($page === 'home') {
            include 'element1.php';
            include 'element2.php';
            include 'testimonials.php';
            include 'partners.php';
        }
        ?>
    </main>

    <?php include 'login.php'; ?>
    <?php include 'register.php'; ?>

    <footer class="bg-dark text-white text-center py-3"><?php include 'footer.php'; ?></footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
   document.addEventListener('DOMContentLoaded', function () {
    // Initialize Bootstrap dropdowns
    var dropdownElements = document.querySelectorAll('.dropdown-toggle');
    dropdownElements.forEach(function (dropdown) {
        new bootstrap.Dropdown(dropdown);
    });

    // Handle Login/Register Modal display from URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const showModal = urlParams.get('showModal');

    if (showModal === 'register') {
        var registerModal = new bootstrap.Modal(document.getElementById('registerModal'));
        registerModal.show();
    } else if (showModal === 'login') {
        var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
        loginModal.show();
    }

    // Optional: Close modal if clicked outside
    var modals = document.querySelectorAll('.modal');
    modals.forEach(function (modal) {
        modal.addEventListener('click', function (e) {
            if (e.target === modal) {
                var bsModal = bootstrap.Modal.getInstance(modal);
                bsModal.hide();
            }
        });
    });

    // Optional: Add functionality to close any open dropdown when clicking outside
    document.addEventListener('click', function (e) {
        const dropdowns = document.querySelectorAll('.dropdown-menu');
        dropdowns.forEach(function (dropdown) {
            if (!dropdown.contains(e.target) && !e.target.closest('.dropdown-toggle')) {
                const dropdownInstance = bootstrap.Dropdown.getInstance(dropdown.previousElementSibling);
                if (dropdownInstance) {
                    dropdownInstance.hide();
                }
            }
        });
    });
});

    </script>
</body>
</html>
