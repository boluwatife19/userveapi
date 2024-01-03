<?php
include '../partials/connect.php';
session_start();
$admin_id = $_SESSION['admin_id'];


if (!isset($admin_id)) {
    // Assuming the default admin ID is 1
    header('location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DASHBOARD</title>
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../style/style.css">
</head>

<body>
    <nav>
       <a class="logo" href="http://localhost:3000">
            <img src="../images/logo.png" alt="Userve Wireless Solution">
            <p>uServe Wireless Solution</p>
</a>
        <ul>
            <li><a href="./logout.php">Change Password</a></li>
            <li><a href="./logout.php">New Admin</a></li>
            <li><a href="./logout.php">LOGOUT</a></li>
        </ul>
    </nav>
    <main class="dashboard">
        <div class="container">
            <div class="img"> <img src="../images/b_cover.jpg" alt="BLOG">
            </div>
            <div class="text">
                <a href="./list.php" class="edit">VIEW LIST</a>
                <a href="./post.php" class="add">ADD NEW</a>
            </div>
        </div>
        <div class="container">
            <div class="img"> <img src="../images/g_cover.jpg" alt="BLOG">
            </div>
            <div class="text">
                <a href="../gallery_components/list.php" class="edit">VIEW LIST</a>
                <a href="../gallery_components/post.php" class="add">ADD NEW</a>
            </div>
        </div>
    </main>
</body>

</html>