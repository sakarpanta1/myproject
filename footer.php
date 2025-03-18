<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Footer Styles */
        footer {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: #fff;
            backdrop-filter: blur(10px);
            padding: 40px 0;
            margin-top: 50px;
            border-top: 2px solid #fff; /* Adds a clean separation */
        }

        footer a {
            color: #fff;
            text-decoration: none;
        }

        footer a:hover {
            color: #f4f4f4;
            text-decoration: underline;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .footer-section {
            flex: 1;
            min-width: 200px;
            margin-bottom: 20px;
        }

        .footer-section h4 {
            margin-bottom: 15px;
            font-size: 18px;
            font-weight: 600;
            color: #fff;
        }

        .footer-section p {
            font-size: 14px;
            line-height: 1.6;
        }

        .social-icons a {
            font-size: 20px;
            margin-right: 15px;
            transition: color 0.3s ease;
        }

        .social-icons a:hover {
            color: #f4f4f4;
        }

        .footer-bottom {
            text-align: center;
            padding: 20px 0;
            background-color: #222;
            margin-top: 20px;
        }

        .footer-bottom p {
            margin: 0;
            font-size: 14px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .footer-content {
                flex-direction: column; /* Stack footer sections vertically on mobile */
                align-items: center;
            }

            .footer-section {
                text-align: center;
                margin-bottom: 20px;
            }

            .footer-bottom {
                text-align: center;
                padding: 15px 0;
            }
        }
    </style>
</head>
<body>
    <footer>
        <div class="footer-content">
            <!-- About Section -->
            <div class="footer-section">
                <h4>About Us</h4>
                <p>
                    We are a company dedicated to providing the best services and solutions
                    to our clients. Our mission is to make your life easier and more productive.
                </p>
            </div>

            <!-- Quick Links Section -->
            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul style="list-style: none; padding: 0;">
                    <li><a href="#home">Home</a></li>
                    <li><a href="#about">About Us</a></li>
                    <li><a href="#services">Services</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </div>

            <!-- Contact Section -->
            <div class="footer-section">
                <h4>Contact Us</h4>
                <p>Email: info@example.com</p>
                <p>Phone: +123 456 7890</p>
                <p>Address: 123 Main St, City, Country</p>
            </div>

            <!-- Social Media Section -->
            <div class="footer-section">
                <h4>Follow Us</h4>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <p>&copy; 2023 Your Company. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
