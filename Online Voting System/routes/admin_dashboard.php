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

// Fetch users and groups data from the database
$users_query = mysqli_query($connect, "SELECT * FROM user WHERE role != 3"); // Exclude admin users
$groups_query = mysqli_query($connect, "SELECT * FROM user WHERE role = 2");

$users_data = mysqli_fetch_all($users_query, MYSQLI_ASSOC);
$groups_data = mysqli_fetch_all($groups_query, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../CSS/stylesheet.css">
    <style>
        /* Additional styles specific to admin dashboard */
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
        }

        .navbar {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        .navbar h1 {
            margin: 0;
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
            margin-left: 20px;
        }

        .container {
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            max-width: 800px;
            background-color: #fff;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            overflow-x: auto; /* Enable horizontal scrolling for tables on smaller screens */
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .image-column img {
            width: 50px; /* Adjust image width as needed */
            height: auto; /* Maintain aspect ratio */
        }

        /* Media Query for smaller screens */
        @media screen and (max-width: 768px) {
            .container {
                margin: 10px auto;
                padding: 10px;
            }

            table {
                width: auto; /* Allow table to shrink to fit smaller screens */
            }

            /* Adjust padding for table cells on smaller screens */
            table, th, td {
                padding: 6px;
            }

            .image-column img {
                width: 30px; /* Adjust image width for smaller screens */
            }
        }
    </style>
</head>
<body>

    <!-- Navigation bar or header section -->
    <header>
        <div class="navbar">
            <h1>Welcome, Admin</h1>
            <a href="logout.php" style="font-size: 30px; color: #007bff; text-decoration: underline;">Logout</a>
        </div>
    </header>

   <!-- Main content section -->
<div class="container">
    <h2>User Management</h2>
    
    <!-- Voter Table -->
    <h3>Voter Management</h3>
    <table>
        <tr>
            <th>SN</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>Password</th>
            <th>Address</th>
            <!-- <th>Image</th> New column for image -->
            <th>Action</th>
        </tr>
        <?php 
        $sn_voter = 1; // Initialize serial number counter for voters
        foreach ($users_data as $user): 
            if ($user['role'] == 1): // Check if the user is a voter
        ?>
                <tr>
                    <td><?php echo $sn_voter; ?></td> <!-- Display serial number -->
                    <td><?php echo $user['name']; ?></td>
                    <td><?php echo $user['mobile']; ?></td>
                    <td><?php echo $user['password']; ?></td> <!-- Display password -->
                    <td><?php echo $user['address']; ?></td>
                    <!-- <td class="image-column"><img src="../images/<?php echo $user['image_path']; ?>" alt="User Image"></td> Display image -->
                    <td>
                        <a href="edit_voter.php?id=<?php echo $user['id']; ?>" class="btn">Edit</a>
                        <a href="delete_voter.php?id=<?php echo $user['id']; ?>" class="btn">Delete</a>
                    </td>
                </tr>
        <?php 
            $sn_voter++; // Increment serial number counter for voters
            endif;
        endforeach; 
        ?>
    </table>
    </div>
<hr>
        <div>
    <!-- Group Table -->
<h3>Group Management</h3>
<table>
    <tr>
        <th>SN</th>
        <th>Name</th>
        <th>Mobile</th>
        <th>Password</th>
        <th>Address</th>
        <th>Votes</th> <!-- Add the Votes column -->
        <th>Action</th>
    </tr>
    <?php 
    $sn_group = 1; // Initialize serial number counter for groups
    foreach ($users_data as $user): 
        if ($user['role'] == 2): // Check if the user is a group
    ?>
            <tr>
                <td><?php echo $sn_group; ?></td> <!-- Display serial number -->
                <td><?php echo $user['name']; ?></td>
                <td><?php echo $user['mobile']; ?></td>
                <td><?php echo $user['password']; ?></td>
                <td><?php echo $user['address']; ?></td>
                <td><?php echo $user['votes']; ?></td> <!-- Display the Votes -->
                <td>
                    <a href="edit_group.php?id=<?php echo $user['id']; ?>" class="btn">Edit</a>
                    <a href="delete_group.php?id=<?php echo $user['id']; ?>" class="btn">Delete</a>
                </td>
            </tr>
    <?php 
        $sn_group++; // Increment serial number counter for groups
        endif;
    endforeach; 
    ?>
</table>
</div>


</body>
</html>
