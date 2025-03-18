<div class="element-container">
    <!-- Left Side: Image -->
    <div class="left">
        <div class="image-container">
            <img src="<?php echo glob('uploads/element2_image.*')[0] ?? 'uploads/default2.jpg'; ?>" alt="Element 2 Image">
        </div>
    </div>

    <!-- Right Side: Text -->
    <div class="right">
        <p><?php echo file_get_contents('element2_text.txt'); ?></p>
    </div>
</div>

<style>
    .element-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        width: 100%;
        height: 100vh; /* Full viewport height */
        margin: 0;
        padding: 0;
        align-items: center; /* Vertically center the content */
    }

    .element-container .left,
    .element-container .right {
        background-color: #f8f8f8;
        padding: 40px;
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .element-container .right p {
        font-size: 1.4rem;
        color: #333;
        line-height: 1.6;
        margin: 0;
    }

    .image-container {
        width: 100%;
        border-radius: 10px;
        overflow: hidden;
    }

    .image-container img {
        width: 100%;
        height: 100%; /* Ensure image fills the height */
        object-fit: cover;
        border-radius: 10px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .element-container {
            grid-template-columns: 1fr;
            gap: 15px;
            height: auto; /* Allow height to adjust on smaller screens */
        }

        .element-container .left,
        .element-container .right {
            padding: 30px;
        }

        .image-container img {
            height: auto; /* Allow image height to adjust on smaller screens */
        }
    }
</style>
