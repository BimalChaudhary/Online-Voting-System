<?php
    include("connect.php");

    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $address = $_POST['address'];
    $image = $_FILES['photo']['name'];
    $tmp_name = $_FILES['photo']['tmp_name'];
    $role = $_POST['role'];

    // Check if mobile number already exists
    $check_mobile_query = mysqli_query($connect, "SELECT * FROM user WHERE mobile = '$mobile'");
    if (mysqli_num_rows($check_mobile_query) > 0) {
        // Mobile number already exists, display error message
        echo '
        <script>
        alert ("Mobile number already exists. Please use a different mobile number.");
        window.location = "../Routes/register.html";
        </script>
        ';
        exit(); // Stop further execution
    }

    if($password == $cpassword)
    {
        move_uploaded_file($tmp_name, "../uploads/$image");
        $insert = mysqli_query($connect, "INSERT INTO user(name, mobile, password, address, photo, role, status, votes) VALUES('$name', '$mobile', '$password', '$address', '$image', '$role', 0, 0)");
        if($insert){
            echo '
            <script>
            alert ("Registration Successful!");
            window.location = "../";
            </script>
            ';
        }
        else {
            echo '
            <script>
            alert ("Some error occurred!");
            window.location = "../Routes/register.html";
            </script>
            ';
        }
    }
    else {
        echo '
        <script>
        alert ("Password and Confirm password do not match!");
        window.location = "../Routes/register.html";
        </script>
        ';
    }
?>
