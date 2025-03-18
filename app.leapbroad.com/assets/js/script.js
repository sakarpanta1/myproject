// Example of how you might use AJAX for dynamic content loading in the dashboard.
$(document).ready(function () {
    // Handle Sidebar Link Clicks
    $('#addStudent').click(function () {
        loadContent('add_student.php');
    });
    $('#searchCourse').click(function () {
        loadContent('search_course.php');
    });
    $('#myStudents').click(function () {
        loadContent('my_students.php');
    });
    $('#applications').click(function () {
        loadContent('applications.php');
    });
    $('#enrollment').click(function () {
        loadContent('enrollment.php');
    });
    $('#institutions').click(function () {
        loadContent('institutions.php');
    });
    $('#manageUsers').click(function () {
        loadContent('manage_users.php');
    });
    $('#commissionHub').click(function () {
        loadContent('commission_hub.php');
    });

    // Function to Load Content Using AJAX
    function loadContent(page) {
        $.ajax({
            url: page,
            type: 'GET',
            success: function (response) {
                $('.main-content').html(response);
            }
        });
    }
});
