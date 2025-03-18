<?php
// Path to the JSON file containing partner details
$partnersFile = 'partners.json';

// Function to read partners from the JSON file
function getPartners($file) {
    if (file_exists($file)) {
        $jsonData = file_get_contents($file);
        return json_decode($jsonData, true);
    }
    return [];
}

// Get partners for display
$partners = getPartners($partnersFile);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Institution Partners</title>
    <style>
        .partners-section {
            text-align: center;
            padding: 50px 20px;
            background-color: #f4f4f4;
        }

        .partners-section h2 {
            font-size: 2rem;
            margin-bottom: 30px;
        }

        .partners-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 30px;
        }

        .partner {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 150px;
            transition: transform 0.3s ease;
        }

        .partner img {
            width: 100%;
            height: auto;
            object-fit: contain;
            margin-bottom: 10px;
        }

        .partner:hover {
            transform: translateY(-10px);
        }

        .partner-name {
            font-weight: 600;
            font-size: 1.1rem;
            margin-top: 10px;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .partners-container {
                flex-direction: column;
                gap: 20px;
            }

            .partner {
                width: 100%;
                max-width: 300px;
            }
        }
    </style>
</head>
<body>

    <section class="partners-section">
        <h2>Our Institution Partners</h2>

        <div class="partners-container">
            <?php if (empty($partners)): ?>
                <p>No partners found.</p>
            <?php else: ?>
                <?php foreach ($partners as $partner): ?>
                    <div class="partner">
                        <img src="<?php echo htmlspecialchars($partner['logo']); ?>" alt="<?php echo htmlspecialchars($partner['name']); ?> Logo">
                        <p class="partner-name"><?php echo htmlspecialchars($partner['name']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>

</body>
</html>
