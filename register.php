<?php session_start(); ?>

<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">Choose Registration Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p class="mb-3">Select the type of registration:</p>
                <!-- Updated buttons to match login.php styling -->
                <a href="register_student.php" class="btn btn-primary btn-lg w-100 mb-2">Register as Student</a>
                <a href="register_institution.php" class="btn btn-success btn-lg w-100 mb-2">Register as Institution</a>
                <a href="register_staff.php" class="btn btn-warning btn-lg w-100 mb-2">Register as Staff</a>
                <a href="register_partner.php" class="btn btn-danger btn-lg w-100 mb-2">Register as Partner</a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>