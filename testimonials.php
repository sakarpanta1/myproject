<?php
// Path to the JSON file
$jsonFile = 'testimonials.json';

// Function to read testimonials from the JSON file
function getTestimonials($file) {
    if (file_exists($file)) {
        $jsonData = file_get_contents($file);
        return json_decode($jsonData, true);
    }
    return [];
}

// Get testimonials for display
$testimonials = getTestimonials($jsonFile);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testimonials</title>
    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            font-size: 2.5rem;
            margin-top: 40px;
            color: #333;
        }

        .testimonial-container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 15px;
        }

        /* Testimonial card styles */
        .testimonial {
            background-color: #fff;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .testimonial:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .testimonial h3 {
            font-size: 1.6rem;
            margin-bottom: 10px;
            color: #333;
        }

        .testimonial p {
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .testimonial .date {
            font-size: 0.9em;
            color: #777;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
                margin-top: 30px;
            }

            .testimonial {
                padding: 15px;
            }

            .testimonial h3 {
                font-size: 1.4rem;
            }

            .testimonial p {
                font-size: 0.95rem;
            }
        }
    </style>
</head>
<body>
    <h1>Testimonials</h1>

    <div class="testimonial-container">
        <?php if (empty($testimonials)): ?>
            <p>No testimonials found.</p>
        <?php else: ?>
            <?php foreach ($testimonials as $testimonial): ?>
                <div class="testimonial">
                    <h3><?php echo htmlspecialchars($testimonial['name']); ?></h3>
                    <p><?php echo htmlspecialchars($testimonial['testimonial']); ?></p>
                    <p class="date">Posted on: <?php echo date('F j, Y', strtotime($testimonial['date_added'])); ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>
