<?php

include '../partials/connect.php';

session_start();

if (isset($_POST['submit'])) {
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $password = $_POST['pass'];

   $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE email = ?");
   $select_admin->execute([$email]);
   $admin = $select_admin->fetch(PDO::FETCH_ASSOC);

   if ($admin && password_verify($password, $admin['password'])) {
      $_SESSION['admin_id'] = $admin['id'];
      header('Location: dashboard.php');
      exit();
   } else {
      header('Location: login.php');
   }
}

// $admin_id = $_SESSION['admin_id'];

// if (!isset($admin_id)) {
//    header('location: http://localhost:3000/blog/admin/admin');
//    exit();
// }

// if (isset($_POST['register'])) {
//    $name = $_POST['name'];
//    $name = filter_var($name, FILTER_SANITIZE_STRING);
//    $email = $_POST['email'];
//    $email = filter_var($email, FILTER_SANITIZE_STRING);
//    $pass = $_POST['pass'];
//    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
//    $cpass = $_POST['cpass'];
//    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

//    $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE email = ?");
//    $select_admin->execute([$email]);

//    if ($select_admin->rowCount() > 0) {
//       $message[] = 'Username already exists!';
//    } else {
//       if ($pass != $cpass) {
//          $message[] = 'Confirm password not matched!';
//          header('Location: http://localhost:3000/blog/admin/register');
//       } else {
//          $hashedPass = password_hash($pass, PASSWORD_DEFAULT); // Hash the password
//          $insert_admin = $conn->prepare("INSERT INTO `admin` (name, email, password) VALUES (?, ?, ?)");
//          $insert_admin->execute([$name, $email, $hashedPass]);
//          header('Location: http://localhost:3000/blog/admin/admin');
//       }
//    }
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="../style/style.css">
    <link rel="shortcut icon" href="../images/logo.png" type="image/x-icon">
   <title>ADMIN LOGIN</title>
</head>

<body>

<nav>
       <a class="logo" href="http://localhost:3000">
            <img src="../images/logo.png" alt="Userve Wireless Solution">
            <p>uServe Wireless Solution</p>
</a>
    </nav>
   <div class="adminc">
      <h1>LOGIN AS AN ADMIN</h1>
      <form  method="post">
         <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" required placeholder="youremail@domain.com" />
         </div>
         <div class="form-group">
            <label>Password</label>
            <input type="Password" name="pass" required placeholder="Enter Your Password" />
         </div>
         <div class="form-group">
            <input type="submit" name="submit" value="LOGIN" required class="submit" />
         </div>
      </form>
   </div>
</body>

</html>