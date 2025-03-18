<?php session_start(); ?>

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Select Your Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p class="mb-3">Please select your role to proceed with login:</p>
                <a href="https://institution.leapbroad.com" class="btn btn-primary btn-lg w-100 mb-2">Institution</a>
                <a href="https://staff.leapbroad.com" class="btn btn-success btn-lg w-100 mb-2">Staff</a>
                <a href="https://students.leapbroad.com/" class="btn btn-warning btn-lg w-100 mb-2">Student</a>
                <a href="https://app.leapbroad.com/" class="btn btn-danger btn-lg w-100 mb-2">Recruitment Partner</a>
            </div>
        </div>
    </div>
</div>