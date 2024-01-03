<?php
include '../partials/connect.php';
session_start();
$admin_id = $_SESSION['admin_id'];


if (!isset($admin_id)) {
    // Assuming the default admin ID is 1
    header('location: login.php');
    exit();
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
}

function reduceTextTo30Words($text)
{
    $words = explode(' ', $text);
    if (count($words) > 30) {
        $words = array_slice($words, 0, 30);
        $text = implode(' ', $words);
    }
    echo  $text;
}

// Items per page
$itemsPerPage = 3;

// Current page (default to the first page)
if (isset($_GET['page'])) {
    $currentPage = $_GET['page'];
} else {
    $currentPage = 1;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BLOG LIST</title>
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

    <div class="admin_list">
        <h1 class="head">ARTICLE LIST</h1>
        <div class="nav_inc">
            <div class="blog_content">
            <?php
                $totalRows = $conn->query("SELECT COUNT(*) FROM `blog`")->fetchColumn();
                $totalPages = ceil($totalRows / $itemsPerPage);

                // Calculate the offset for the SQL query
                $offset = ($currentPage - 1) * $itemsPerPage;

                // SQL query with pagination
                $select_posts = $conn->prepare("SELECT * FROM `blog` ORDER BY `id` DESC LIMIT :offset, :itemsPerPage");
                $select_posts->bindParam(':offset', $offset, PDO::PARAM_INT);
                $select_posts->bindParam(':itemsPerPage', $itemsPerPage, PDO::PARAM_INT);
                $select_posts->execute();
                if ($select_posts->rowCount() > 0) {
                    while ($fetch_post = $select_posts->fetch(PDO::FETCH_ASSOC)) {
                        $post_id = $fetch_post['id']; ?>
                        <div class="cont" key=<?= $fetch_post['id'] ?>>
                            <div class="image">
                                <img src="../uploaded_img/<?= $fetch_post['image'] ?>" alt="">
                            </div>
                            <div class="text">
                                <h1><?= $fetch_post['title'] ?></h1>
                                <p><?= $fetch_post['category'] ?></p>
                            </div>
                            <span>
                                <p class='content-150'><?php reduceTextTo30Words($fetch_post['content']) ?>...</p>
                                <div class="nice">
                                    <a href="http://localhost:3000/blog/<?= $fetch_post['id'] ?>">
                                        <button>READ</button>
                                    </a>
                                    <a href="edit_post.php?post_id=<?= $post_id ?>">
                                        <button class="edit">EDIT</button>
                                    </a>
                                </div>
                                <form method="post">
                                    <input type="hidden" name="post_id" value="<?= $post_id ?>">
                                    <input type="submit" value="DELETE" name="delete" class="submit">
                                </form>
                            </span>
                        </div>
                <?php }
                } ?>
            </div>
            <!-- Pagination -->
            <?php // Previous and Next buttons
echo "<div class='pagination'>";
if ($currentPage > 1) {
    $prevPage = $currentPage - 1;
    echo "<a class='prev' href='?page=$prevPage'>Prev</a>";
}

if ($currentPage < $totalPages) {
    $nextPage = $currentPage + 1;
    echo "<a class='next' href='?page=$nextPage'>Next</a>";
}
echo "</div>";
?>
        </div>
    </div>
</body>

</html>