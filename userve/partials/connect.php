<?php

$db_host = 'localhost'; // Use the correct hostname
$db_name = 'userve_api'; // Use your database name
$user_name = 'userve_api'; // Use your MySQL user name
$user_password = 'Boluwatife19'; // Use your MySQL password


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