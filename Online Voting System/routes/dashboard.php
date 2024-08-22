<?php
session_start();
if (!isset($_SESSION['userdata'])) {
    header("location:../");
}

$userdata = $_SESSION['userdata'];
$groupsdata = $_SESSION['groupsdata'];

if ($_SESSION['userdata']['status'] == 0 && $_SESSION['userdata']['role'] == 1) {
    $status = '<b style="color:red">Not Voted</b>';
} else {
    $status = '<b style="color:green">Voted</b>';
}
?>

<html>
<head>
    <title>Online Voting System - Dashboard</title>
    <link rel="stylesheet" href="../CSS/stylesheet.css">
</head>
<body>

<style>
    #backbtn {
        padding: 5px;
        font-size: 15px;
        border-radius: 5px;
        background-color: #3498db;
        color: white;
        float: left;
        margin: 10px;
    }
    #logoutbtn {
        padding: 5px;
        font-size: 15px;
        border-radius: 5px;
        background-color: #3498db;
        color: white;
        float: right;
        margin: 10px;
    }
    #profile {
        background-color: white;
        width: 20%;
        padding: 10px;
        float: left;
    }
    #Group {
        background-color: white;
        width: 75%;
        padding: 10px;
        float: right;
    }
    #votebtn {
        padding: 5px;
        font-size: 15px;
        border-radius: 5px;
        background-color: #3498db;
        color: white;
    }
    #mainSection {
        padding: 10px;
    }
    #headerSection {
        padding: 10px;
    }
    #voted {
        padding: 5px;
        font-size: 15px;
        border-radius: 5px;
        background-color: green;
        color: white;
    }
</style>

<div id="mainSection">
    <center>
        <div id="headerSection">
            <a href="../"><button id="backbtn">Back</button></a><br>
            <a href="logout.php"><button id="logoutbtn">Logout</button></a>
            <?php if ($userdata['role'] == 1): ?>
                <h4 style="font-size: 30px; color: gold; text-decoration: underline; float: left;">Voter</h4>
                <h4 style="font-size: 30px; color: gold; text-decoration: underline; float: right;">Group</h4>
            <?php else: ?>
                <h4 style="font-size: 30px; color: gold; text-decoration: underline; float: left;">Group</h4>
            <?php endif; ?>
            <h1>Online Voting System</h1>
        </div>
    </center>
    <hr>

    <?php if ($userdata['role'] == 1): ?>
        <div id="profile">
            <center><img src="../uploads/<?php echo $userdata['photo'] ?>" height="100" width="100"></center><br><br>
            <b>Name: </b><?php echo $userdata['name'] ?><br><br>
            <b>Mobile: </b><?php echo $userdata['mobile'] ?><br><br>
            <b>Address: </b><?php echo $userdata['address'] ?><br><br>
            <b>Status: </b><?php echo $status ?><br><br>
        </div>
    <?php endif; ?>

    <div id="Group">
        <?php
        if ($userdata['role'] == 1 && $_SESSION['groupsdata']) {
            for ($i = 0; $i < count($groupsdata); $i++) {
                ?>
                <div>
                    <img style="float: right" src="../uploads/<?php echo $groupsdata[$i]['photo'] ?>" height="100" width="100">
                    <b>Group Name: </b><?php echo $groupsdata[$i]['name'] ?><br><br>
                    <b>Votes: </b><?php echo $groupsdata[$i]['votes'] ?><br><br>
                    <b>Mobile: </b><?php echo $groupsdata[$i]['mobile'] ?><br><br>
                    <b>Address: </b><?php echo $groupsdata[$i]['address'] ?><br><br>
                    <form action="../api/vote.php" method="POST">
                        <input type="hidden" name="gvotes" value="<?php echo $groupsdata[$i]['votes'] ?>">
                        <input type="hidden" name="gid" value="<?php echo $groupsdata[$i]['id'] ?>">
                        <?php
                        if ($userdata['status'] == 0) {
                            ?>
                            <input type="submit" name="votebtn" value="Vote" id="votebtn">
                            <?php
                        } else {
                            ?>
                            <button disabled type="button" name="votebtn" value="Vote" id="voted">Voted</button>
                            <?php
                        }
                        ?>
                    </form>
                </div>
                <hr>
                <?php
            }
        } elseif ($userdata['role'] == 2) { // Assuming role 2 is for group users
            ?>
            <div>
                <img style="float: right" src="../uploads/<?php echo $userdata['photo'] ?>" height="100" width="100">
                <b>Group Name: </b><?php echo $userdata['name'] ?><br><br>
                <b>Votes: </b><?php echo $userdata['votes'] ?><br><br>
                <b>Mobile: </b><?php echo $userdata['mobile'] ?><br><br>
                <b>Address: </b><?php echo $userdata['address'] ?><br><br>
            </div>
            <hr>
            <?php
        } else {
            echo "<p>No groups data available.</p>";
        }
        ?>
    </div>
</div>
</body>
</html>
