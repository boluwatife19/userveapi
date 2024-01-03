<?php
// api.php
require '../partials/connect.php';

// Set the response content type to JSON
header('Content-Type: application/json');

// Allow cross-origin requests (replace example.com with your Next.js application's domain)
header('Access-Control-Allow-Origin: http://localhost:3000'); // Replace with your actual domain

try {
    //GALLERY QUERY

    // Sample data retrieval and response
    $gallery_result = $conn->prepare("SELECT * FROM `gallery` ORDER BY `id` DESC LIMIT 1, 18446744073709551615");
$gallery_result->execute(); // LIMIT 1, 18446744073709551615 ensures all rows except the first one
    $gallery_data = $gallery_result->fetchAll(PDO::FETCH_ASSOC);

    $gallery_query = "SELECT * FROM `gallery` ORDER BY `id` DESC LIMIT 1";
    $gallery_hero = $conn->prepare($gallery_query);
    $gallery_hero->execute();
    $gallery_latestPost = $gallery_hero->fetch(PDO::FETCH_ASSOC);

    // Combine the data into a single JSON response
    $response = array(
        "gallery" => $gallery_data,
        "latestgallery" => $gallery_latestPost
    );

    echo json_encode($response);
} catch (PDOException $e) {
    // Handle database connection errors
    $response = array(
        "error" => "Database connection error: " . $e->getMessage()
    );
    echo json_encode($response);
}
