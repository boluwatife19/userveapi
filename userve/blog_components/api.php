<?php
// api.php
require '../partials/connect.php';

// Set the response content type to JSON
header('Content-Type: application/json');

// Allow cross-origin requests (replace example.com with your Next.js application's domain)
header('Access-Control-Allow-Origin: http://localhost:3000'); // Replace with your actual domain

try {
    // Sample data retrieval and response
    $result = $conn->prepare("SELECT * FROM `blog` ORDER BY `id` DESC ");
    $result->execute();
    $data = $result->fetchAll(PDO::FETCH_ASSOC);

    // Sample data retrieval and response
    $result1 = $conn->prepare("SELECT * FROM `blog` ORDER BY `id` DESC LIMIT 1, 18446744073709551615");
    $result1->execute(); // LIMIT 1, 18446744073709551615 ensures all rows except the first one
    $data1 = $result1->fetchAll(PDO::FETCH_ASSOC);

    $query = "SELECT * FROM `blog` ORDER BY `id` DESC LIMIT 1";
    $hero = $conn->prepare($query);
    $hero->execute();
    $latestPost = $hero->fetch(PDO::FETCH_ASSOC);

    // Combine the data into a single JSON response
    $response = array(
        "posts" => $data,
        "posts1" => $data1,
        "latestPost" => $latestPost,
    );

    echo json_encode($response);
} catch (PDOException $e) {
    // Handle database connection errors
    $response = array(
        "error" => "Database connection error: " . $e->getMessage()
    );
    echo json_encode($response);
}


