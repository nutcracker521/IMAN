<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Content-Type: text/plain");

session_start();
require 'config.php'; // Ensure this contains the database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    die("Error: Unauthorized - Please log in first.");
}

$user_id = $_SESSION['user_id']; // Get the logged-in user's ID

// Ensure it's a POST request
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    die("Error: Method Not Allowed");
}

// Get form data and sanitize inputs
$deck_name = trim($_POST['deck_name'] ?? "");
$description = trim($_POST['description'] ?? "");
$category = trim($_POST['category'] ?? "");
$level = trim($_POST['level'] ?? "");
$visibility = trim($_POST['visibility'] ?? "private"); // Default to private
$tags = trim($_POST['tags'] ?? "");

// Validate required fields
if (empty($deck_name) || empty($description) || empty($category) || empty($level)) {
    die("Error: Required fields missing");
}

// Handle file upload safely
$deck_icon = "";
if (isset($_FILES['deck_icon']) && $_FILES['deck_icon']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = "uploads/";
    $filename = basename($_FILES['deck_icon']['name']);
    $deck_icon = $uploadDir . $filename;

    // Ensure upload folder exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    if (!move_uploaded_file($_FILES['deck_icon']['tmp_name'], $deck_icon)) {
        die("Error: File upload failed");
    }
}

// Insert into database with user_id
$sql = "INSERT INTO decks (deck_name, description, category, level, visibility, tags, deck_icon, user_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error: Failed to prepare SQL statement");
}

$stmt->bind_param("sssssssi", $deck_name, $description, $category, $level, $visibility, $tags, $deck_icon, $user_id);

if ($stmt->execute()) {
    echo "Deck created successfully!";
} else {
    echo "Error: " . $stmt->error;
}

// Close connections
$stmt->close();
$conn->close();
?>
