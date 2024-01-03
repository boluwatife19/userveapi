<?php

include '../partials/connect.php';


session_start();
$admin_id = $_SESSION['admin_id'];


if (!isset($admin_id)) {
    // Assuming the default admin ID is 1
    header('location: login.php');
    exit();
}

if(!isset($_GET['post_id'])){
    header('location: list.php');
}else{
    $get_id = $_GET['post_id'];
}

if (isset($_POST['save'])) {

    $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
    $minute = filter_var($_POST['minute'], FILTER_SANITIZE_STRING);
    $category = filter_var($_POST['category'], FILTER_SANITIZE_STRING);
    $content = filter_var($_POST['content'], FILTER_SANITIZE_STRING);
    $content2 = filter_var($_POST['content2'], FILTER_SANITIZE_STRING);
    $content3 = filter_var($_POST['content3'], FILTER_SANITIZE_STRING);

    $update_post = $conn->prepare("UPDATE `blog` SET title = ?, minute = ?, category = ?, content = ?, content2 = ?, content3 = ? WHERE id = ?");
    $update_post->execute([$title, $minute, $category, $content, $content2, $content3, $get_id]);

    $message[] = 'post updated!';


    $old_image = $_POST['old_image'];
    $old_image = filter_var($old_image, FILTER_SANITIZE_STRING);

    $old_image2 = $_POST['old_image2'];
    $old_image2 = filter_var($old_image2, FILTER_SANITIZE_STRING);

    $old_image3 = $_POST['old_image3'];
    $old_image3 = filter_var($old_image3, FILTER_SANITIZE_STRING);

    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/' . $image;

     // Handle image2 uploads
     $image2 = $_FILES['image2']['name'];
     $image2 = filter_var($image2, FILTER_SANITIZE_STRING);
     $image2_tmp_name = $_FILES['image2']['tmp_name'];
     $image2_folder = '../uploaded_img/' . $image2;
     $image2_size = $_FILES['image2']['size'];
 
     // Handle image3 uploads
     $image3 = $_FILES['image3']['name'];
     $image3 = filter_var($image3, FILTER_SANITIZE_STRING);
     $image3_tmp_name = $_FILES['image3']['tmp_name'];
     $image3_folder = '../uploaded_img/' . $image3;
     $image3_size = $_FILES['image3']['size'];


    $select_image = $conn->prepare("SELECT * FROM `blog` WHERE image = ?");
    $select_image->execute(([$image]));

    if (!empty($image)) {
        if ($select_image->rowCount() > 0 and $image != '') {
            $message[] = 'Please Rename your image!';
        } elseif ($image_size > 2000000) {
            $message[] = "Image is too Large!!";
        } else {
            $update_image = $conn->prepare("UPDATE `blog` SET image = ? WHERE id = ?");
            $update_image->execute([$image, $get_id]);
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'image updated!';
            if ($old_image != $image and $old_image != '') {
                unlink('../uploaded_img/' . $old_image);
            }
        }
    } else {
        $image = '';
    }

    // Code for image2
$select_image2 = $conn->prepare("SELECT * FROM `blog` WHERE image2 = ?");
$select_image2->execute([$image2]);

if (!empty($image2)) {
    if ($select_image2->rowCount() > 0 && $image2 != '') {
        $message[] = 'Please Rename your image2!';
    } elseif ($image2_size > 2000000) {
        $message[] = "Image2 is too Large!!";
    } else {
        $update_image2 = $conn->prepare("UPDATE `blog` SET image2 = ? WHERE id = ?");
        $update_image2->execute([$image2, $get_id]);
        move_uploaded_file($image2_tmp_name, $image2_folder);
        $message[] = 'Image2 updated!';
        if ($old_image2 != $image2 && $old_image2 != '') {
            unlink('../uploaded_img/' . $old_image2);
        }
    }
} else {
    $image2 = '';
}

// Code for image3
$select_image3 = $conn->prepare("SELECT * FROM `blog` WHERE image3 = ?");
$select_image3->execute([$image3]);

if (!empty($image3)) {
    if ($select_image3->rowCount() > 0 && $image3 != '') {
        $message[] = 'Please Rename your image3!';
    } elseif ($image3_size > 2000000) {
        $message[] = "Image3 is too Large!!";
    } else {
        $update_image3 = $conn->prepare("UPDATE `blog` SET image3 = ? WHERE id = ?");
        $update_image3->execute([$image3, $get_id]);
        move_uploaded_file($image3_tmp_name, $image3_folder);
        $message[] = 'Image3 updated!';
        if ($old_image3 != $image3 && $old_image3 != '') {
            unlink('../uploaded_img/' . $old_image3);
        }
    }
} else {
    $image3 = '';
}

    header('location: list.php');
}?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDIT BLOG</title>
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
    
<div class="edit_container">
        <h1>EDIT POST</h1>
        <?php
            $select_posts = $conn->prepare("SELECT * FROM `blog` WHERE id = ?");
            $select_posts->execute([$get_id]);
            if ($select_posts->rowCount() > 0) {
                while ($fetch_post = $select_posts->fetch(PDO::FETCH_ASSOC)) {
                    $post_id = $fetch_post['id']; ?>
          <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="old_image" value=<?= $fetch_post['image']?>>
            <input type="hidden" name="id" value=<?= $fetch_post['id']?>>
            <input type="hidden" name="old_image2" value=<?= $fetch_post['image2']?>>
            <input type="hidden" name="old_image3" value=<?= $fetch_post['image3']?>>
            <div class="form-group">
              <label>TITLE</label>
              <input type="text"  required  name="title" value = "<?= $fetch_post['title']?>" >
            </div>
            <div class="form-group">
              <label>MINUTE</label>
              <input type="number"  required  name="minute"  value = "<?= $fetch_post['minute']?>">
            </div>
            <div class="form-group">
              <label>CATEGORY</label>
              <input type="text"  required  name="category"  value = "<?= $fetch_post['category']?>">
            </div>
            <div class="form-group">
              <label>TEXT FIRST SECTION</label>
              <input type="text"  required  name="content"  value = "<?= $fetch_post['content']?>" >
            </div>
            <div class="form-group">
              <label>TEXT SECOND SECTION</label>
              <input type="text"  required  name="content2"  value = "<?= $fetch_post['content2']?>">
            </div>
            <div class="form-group">
              <label>TEXT Last SECTION</label>
              <input type="text"  required  name="content3"  value = "<?= $fetch_post['content3']?>">
            </div>
            <span>Ignore the below elements if you don't want to change the image</span>
            <div class="form-group">
              <label>COVER IMAGE</label>
              <input
                type="file"
                name="image"
              />
            </div>
            <div class="form-group">
              <label>IMAGE1</label>
              <input
                type="file"
                name="image2"
              />
            </div>
            <div class="form-group">
              <label>IMAGE2</label>
              <input
                type="file"
                name="image3"
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