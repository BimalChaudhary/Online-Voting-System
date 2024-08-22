<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    // Redirect to login page or show access denied message
    header("Location: ../index.html");
    exit();
}

// Include your database connection file
include('../api/connect.php');

// Check if the user ID is provided in the URL
if (isset($_GET['id'])) {
    // Sanitize the user ID input to prevent SQL injection
    $user_id = mysqli_real_escape_string($connect, $_GET['id']);

    // Perform the deletion query
    $delete_query = mysqli_query($connect, "DELETE FROM user WHERE id = '$user_id' AND role = 1"); // Deleting only voter (role = 1) records

    if ($delete_query) {
        // Redirect back to the admin dashboard with success message
        header("Location: admin_dashboard.php?delete_success=true");
        exit();
    } else {
        // Redirect back to the admin dashboard with error message if deletion fails
        header("Location: admin_dashboard.php?delete_error=true");
        exit();
    }
} else {
    // Redirect back to the admin dashboard if user ID is not provided in the URL
    header("Location: admin_dashboard.php");
    exit();
}
?>
