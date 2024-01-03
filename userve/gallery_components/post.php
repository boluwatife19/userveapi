<?php
include '../partials/connect.php';
session_start();
$admin_id = $_SESSION['admin_id'];


if (!isset($admin_id)) {
    // Assuming the default admin ID is 1
    header('location: ../blog_components/login.php');
    exit();
}

if (isset($_POST['newgallery'])) {
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);


    // Handle image uploads for each image separately
    $image = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/gallery/' . $image;
    $image_size = $_FILES['image']['size'];

    // Check if image names are repeated
    $message = [];

    if (file_exists($image_folder)) {
        $message[] = 'Image name repeated';
    }

    // Validate image sizes
    if ($image_size > 2000000) {
        $message[] = 'Image is too large';
    }

    // If no errors so far, move uploaded files
    if (empty($message)) {
        move_uploaded_file($image_tmp_name, $image_folder);

        // Handle database queries with distinct variable names
        $insert_post = $conn->prepare("INSERT INTO `gallery` (description, image) VALUES(?,?)");
        $insert_post->execute([$description, $image]);

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
    $select_image = $conn->prepare("SELECT * FROM `gallery` WHERE id = ? ");
    $select_image->execute([$delete_id]);
    $fetch_image = $select_image->fetch(PDO::FETCH_ASSOC);
    if ($fetch_image['image'] != '') {
        unlink('../uploaded_img/gallery/' . $fetch_image['image']);
    }
    $delete_posts = $conn->prepare("DELETE FROM `gallery` WHERE id = ?");
    $delete_posts->execute([$delete_id]);
    $message[] = 'Post Deleted Successfully! ';
    header("Location: http://localhost:3000/blog/admin/list");
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POST GALLERY</title>
    <link rel="stylesheet" href="../style/style.css">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
</head>

<body>

    <nav>
        <a class="logo" href="http://localhost:3000">
            <img src="../images/logo.png" alt="Userve Wireless Solution">
            <p>uServe Wireless Solution</p>
        </a>
        <ul>
            <li><a href="../blog_components/logout.php">LOGOUT</a></li>
        </ul>
    </nav>
    <div class="post">
        <h1>FILL ALL REQUIRED INPUTS</h1>
        <form method="post" encType="multipart/form-data" class="input-form">

            <div class="form-group">
                <label>Input Article Description</label>
                <input type="text" name="description" required />
            </div>
            <div class="form-group">
                <label>Input The Cover Image</label>
                <input type="file" accept="image/jpg, image/jpeg, image/png, image/webp" name="image" required>
            </div>
            <div class="form-group">
                <input type="submit" value="SUBMIT" name="newgallery" class="submit">
            </div>
        </form>
    </div>
</body>

</html>