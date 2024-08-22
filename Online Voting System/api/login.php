<?php
session_start();
include("connect.php");

$mobile = $_POST['mobile'];
$password = $_POST['password'];
$role = $_POST['role'];

// Check if the user is an admin
if ($role == 3) {
    // Assuming you have admin credentials stored in variables
    $admin_mobile = "9865447501";
    $admin_password = "2002"; // Change this to your admin password

    if ($mobile === $admin_mobile && $password === $admin_password) {
        // Admin login successful
        $_SESSION['admin'] = true;
        echo '
        <script>
        window.location = "../routes/admin_dashboard.php";
        </script>
        ';
        exit();
    }
}

// Regular user login
$check = mysqli_query($connect, "SELECT * FROM user WHERE mobile = '$mobile' AND password = '$password' AND role = '$role' ");

if(mysqli_num_rows($check) > 0) {
    $userdata = mysqli_fetch_array($check);
    $groups = mysqli_query($connect, "SELECT * FROM user WHERE role = 2");
    $groupsdata = mysqli_fetch_all($groups, MYSQLI_ASSOC);

    $_SESSION['userdata'] = $userdata;
    $_SESSION['groupsdata'] = $groupsdata;

    echo '
    <script>
    window.location = "../routes/dashboard.php";
    </script>
    ';
} else {
    echo '
    <script>
    alert ("Invalid Credential or User not found !");
    window.location = "../";
    </script>
    ';
}
?>
