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

// Check if the user ID is provided in the URL parameter
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Fetch the user data from the database based on the user ID
    $user_query = mysqli_query($connect, "SELECT * FROM user WHERE id = '$user_id'");
    $user_data = mysqli_fetch_assoc($user_query);

    // Check if user data is found
    if (!$user_data) {
        echo "User not found!";
        exit();
    }
} else {
    echo "User ID not provided!";
    exit();
}

// Handle form submission to update user data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $password = $_POST['password'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];

    // Update user data in the database
    $update_query = mysqli_query($connect, "UPDATE user SET name = '$name', password = '$password', mobile = '$mobile', address = '$address' WHERE id = '$user_id'");

    if ($update_query) {
        // Show alert message if update is successful
        echo "<script>alert('Group data updated successfully!');</script>";
    } else {
        echo "Error updating group data: " . mysqli_error($connect);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="../CSS/stylesheet.css">
    <style>
        /* Add your custom CSS styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
        }

        .container {
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            max-width: 500px;
            background-color: #fff;
        }

        h2 {
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <!-- Navigation bar or header section -->
    <header>
        <div class="navbar">
            <h1>Edit Group</h1>
            <a href="admin_dashboard.php" style="font-size: 20px; color: #007bff; text-decoration: underline;">Back to Dashboard</a>
        </div>
    </header>

    <!-- Main content section -->
    <div class="container">
        <h2>Edit Group</h2>
        <form action="" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter your Name (max 20 characters)" maxlength="20" autocomplete="off" value="<?php echo $user_data['name']; ?>" required>
            <label for="password">Password:</label>
            <input type="text" id="password" name="password" placeholder="Password (4 digits)" maxlength="4" autocomplete="off" value="<?php echo $user_data['password']; ?>" required>
            <label for="mobile">Mobile:</label>
            <input type="text" id="mobile" name="mobile"  placeholder="Enter your Mobile  Number (10 digits)" pattern="[0-9]{10}" 
        title="ID Number must be 10 digits" required oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);" autocomplete="off" value="<?php echo $user_data['mobile']; ?>" required>
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" placeholder="Address (max 10 characters)" maxlength="10"
             value="<?php echo $user_data['address']; ?>" required>
            <button type="submit">Update Group</button>
        </form>
    </div>
    <!-- Footer section -->
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Your Company Name</p>
    </footer>

</body>
</html>
