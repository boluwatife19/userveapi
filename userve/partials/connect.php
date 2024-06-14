<?php

$db_host = ''; // Use the correct hostname
$db_name = ''; // Use your database name
$user_name = ''; // Use your MySQL user name
$user_password = ''; // Use your MySQL password


$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $user_name, $user_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 } catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
 }
?>
