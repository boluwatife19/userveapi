<?php

include '../partials/connect.php';


session_start();
$admin_id = $_SESSION['admin_id'];


if (!isset($admin_id)) {
    // Assuming the default admin ID is 1
    header('location: ../blog_components/login.php');
    exit();
}

if(!isset($_GET['post_id'])){
    header('location: list.php');
}else{ 
    $get_id = $_GET['post_id'];
}

if (isset($_POST['save'])) {

    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $update_post = $conn->prepare("UPDATE `gallery` SET description = ? WHERE id = ?");
    $update_post->execute([$description, $get_id]);


    $message[] = 'post updated!';


    $old_image = $_POST['old_image'];
    $old_image = filter_var($old_image, FILTER_SANITIZE_STRING);

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/gallery/' . $image;

    $select_image = $conn->prepare("SELECT * FROM `gallery` WHERE image = ?");
    $select_image->execute(([$image]));

    if (!empty($image)) {
        if ($select_image->rowCount() > 0 and $image != '') {
            $message[] = 'Please Rename your image!';
        } elseif ($image_size > 2000000) {
            $message[] = "Image is too Large!!";
        } else {
            $update_image = $conn->prepare("UPDATE `gallery` SET image = ? WHERE id = ?");
            $update_image->execute([$image, $get_id]);
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'image updated!';
            if ($old_image != $image and $old_image != '') {
                unlink('../uploaded_img/gallery/' . $old_image);
            }
        }
    } else {
        $image = '';
    }

    header('location: list.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDIT POST</title>
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
            <li><a href="../blog_components/logout.php">LOGOUT</a></li>
        </ul>
    </nav>
<div class="edit_container">
        <h1>EDIT POST</h1>
        <?php
            $select_posts = $conn->prepare("SELECT * FROM `gallery` WHERE id = ?");
            $select_posts->execute([$get_id]);
            if ($select_posts->rowCount() > 0) {
                while ($fetch_post = $select_posts->fetch(PDO::FETCH_ASSOC)) {
                    $post_id = $fetch_post['id']; ?>
          <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="old_image" value=<?= $fetch_post['image']?>>
            <input type="hidden" name="id" value=<?= $fetch_post['id']?>>
            <div class="form-group">
              <label>DESCRIPTION</label>
              <input type="text"  required  name="description" value = "<?= $fetch_post['description']?>" >
            </div>
            <span>Ignore the below element if you don't want to change the image</span>
            <div class="form-group">
              <label>COVER IMAGE</label>
              <input
                type="file"
                name="image"
              />
            </div>
            <div class="flex-btn">
              <button type="submit" name="save" class="save-btn">
                SAVE
              </button>
            </div>
          </form>
          <?php }}?>
      </div>
</body>
</html>