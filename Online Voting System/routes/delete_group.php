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

// Check if the group ID is provided via GET request
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $group_id = $_GET['id'];

    // Delete the group's record from the database
    $delete_query = mysqli_query($connect, "DELETE FROM user WHERE id = '$group_id' AND role = 2");

    if ($delete_query) {
        // Redirect back to the admin dashboard or display a success message
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Error deleting group: " . mysqli_error($connect);
        exit();
    }
} else {
    // Group ID not provided
    echo "Group ID not provided!";
    exit();
}
?>
