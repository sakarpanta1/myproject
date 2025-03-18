<div class="cover-container">
    <div class="cover-image" style="background: url('<?php echo glob("uploads/cover_image.*")[0] ?? "uploads/default_cover.jpg"; ?>') no-repeat center top/cover;">
    </div>
    <div class="cover-text">
        <h2><?php echo file_get_contents('cover_text.txt'); ?></h2>
        <a href="#study-destinations" class="btn btn-lg btn-primary">Explore Now</a>
    </div>
</div>

<style>
    .cover-container {
        position: relative;
        width: 100%;
        height: 70vh; /* 70% of viewport height, cropping 30% from the bottom */
        overflow: hidden;
    }

    .cover-image {
        width: 100%;
        height: 100vh; /* Full viewport height */
        position: absolute;
        top: 0;
        left: 0;
        background-size: cover;
        background-position: center top; /* Moves focus to the top, cropping bottom */
        z-index: -1;
    }

    .cover-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #fff;
        text-align: center;
        max-width: 80%;
    }

    .cover-text h2 {
        font-weight: bold;
        font-size: 3rem;
        color: #fff;
        text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.7);
        margin-bottom: 20px;
    }

    .cover-text .btn {
        background-color: #2575fc;
        padding: 12px 28px;
        border-radius: 30px;
        font-weight: bold;
        font-size: 1.2rem;
        color: #fff;
        text-decoration: none;
    }

    .cover-text .btn:hover {
        background-color: #1b5fd9;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .cover-container {
            height: 50vh; /* Reduce height on smaller screens */
        }

        .cover-text h2 {
            font-size: 2rem;
        }

        .cover-text .btn {
            font-size: 1rem;
        }
    }
</style>
