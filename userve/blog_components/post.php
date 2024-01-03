<?php
include '../partials/connect.php';
session_start();
$admin_id = $_SESSION['admin_id'];


if (!isset($admin_id)) {
    // Assuming the default admin ID is 1
    header('location: login.php');
    exit();
}
if (isset($_POST['submitarticle'])) {
    $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
    $minute = filter_var($_POST['minute'], FILTER_SANITIZE_STRING);
    $category = filter_var($_POST['category'], FILTER_SANITIZE_STRING);
    $content = filter_var($_POST['content'], FILTER_SANITIZE_STRING);
    $content2 = filter_var($_POST['content2'], FILTER_SANITIZE_STRING);
    $content3 = filter_var($_POST['content3'], FILTER_SANITIZE_STRING);

    // Handle image uploads for each image separately
    $image = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/' . $image;
    $image_size = $_FILES['image']['size'];

    // Handle image2 uploads
    $image2 = $_FILES['image2']['name'];
    $image2_tmp_name = $_FILES['image2']['tmp_name'];
    $image2_folder = '../uploaded_img/' . $image2;
    $image2_size = $_FILES['image2']['size'];

    // Handle image3 uploads
    $image3 = $_FILES['image3']['name'];
    $image3_tmp_name = $_FILES['image3']['tmp_name'];
    $image3_folder = '../uploaded_img/' . $image3;
    $image3_size = $_FILES['image3']['size'];

    // Check if image names are repeated
    $message = [];

    if (file_exists($image_folder) || file_exists($image2_folder) || file_exists($image3_folder)) {
        $message[] = 'Image name repeated';
    }

    // Validate image sizes
    if ($image_size > 2000000 || $image2_size > 2000000 || $image3_size > 2000000) {
        $message[] = 'Image is too large';
    }

    // If no errors so far, move uploaded files
    if (empty($message)) {
        move_uploaded_file($image_tmp_name, $image_folder);
        move_uploaded_file($image2_tmp_name, $image2_folder);
        move_uploaded_file($image3_tmp_name, $image3_folder);

        // Handle database queries with distinct variable names
        $insert_post = $conn->prepare("INSERT INTO `blog` (title, content, category, minute, content2, content3, image, image2, image3) VALUES(?,?,?,?,?,?,?,?,?)");
        $insert_post->execute([$title, $content, $category, $minute, $content2, $content3, $image, $image2, $image3]);

        // Redirect the user after successful insert
        header("Location: list.php");
    } else {
        // Handle validation errors
        $response = array(
            "error" => $message
        );
        echo json_encode($response);
    }
}

if (isset($_POST['delete'])) {
    $delete_id = $_POST['post_id'];
    $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
    $select_image = $conn->prepare("SELECT * FROM `blog` WHERE id = ? ");
    $select_image->execute([$delete_id]);
    $fetch_image = $select_image->fetch(PDO::FETCH_ASSOC);
    if ($fetch_image['image'] != '') {
        unlink('../uploaded_img/' . $fetch_image['image']);
    }
    $delete_posts = $conn->prepare("DELETE FROM `blog` WHERE id = ?");
    $delete_posts->execute([$delete_id]);
    $message[] = 'Post Deleted Successfully! ';
    header("Location: list.php");
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN POST</title>
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
            <li><a href="./logout.php">LOGOUT</a></li>
        </ul>
    </nav>
    <div class="post">
        <h1>FILL ALL REQUIRED INPUTS</h1>
        <form method="post"  enctype="multipart/form-data" class="input-form">
            <div class="form-group">
                <label>Input Article Title</label>
                <input type="text" name="title" required />
            </div>
            <div class="form-group">
                <label>Input Article Category</label>
                <input type="text" name="category" required />
            </div>
            <div class="form-group">
                <label>Input The Minute It Will Take To Read</label>
                <input type="number" name="minute" required />
            </div>
            <div class="form-group">
                <label>Input The Cover Image</label>
                <input type="file" accept="image/jpg, image/jpeg, image/png, image/webp" name="image" required />
            </div>
            <div class="form-group">
                <label>Enter the First Text Section</label>
                <input type="text" name="content" required />
            </div>
            <div class="form-group">
                <label>Input The First Section Image</label>
                <input type="file" accept="image/jpg, image/jpeg, image/png, image/webp" name="image2" required />
            </div>
            <div class="form-group">
                <label>Enter the Second Text Section</label>
                <input type="text" name="content2" required />
            </div>
            <div class="form-group">
                <label>Input The Last Section Image</label>
                <input type="file" accept="image/jpg, image/jpeg, image/png, image/webp" name="image3" required />
            </div>
            <div class="form-group">
                <label>Enter the Last Text Section</label>
                <input type="text" name="content3" required />
            </div>
            <div class="form-group">
                <input type="submit" value="submit" name="submitarticle" class="submit" />

            </div>
        </form>
    </div>
</body>

</html>