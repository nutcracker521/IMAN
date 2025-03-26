<?php
session_start();
header("Content-Type: application/json");
require 'db_connection.php';  // Ensure you have a separate database connection file

// Check if the user is logged in
$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized - Please log in first."]);
    exit;
}

// Fetch decks that are either public or belong to the logged-in user
$sql = "SELECT id, deck_name, description, category, level, visibility, tags, deck_icon 
        FROM decks 
        WHERE user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$decks = [];
while ($row = $result->fetch_assoc()) {
    $decks[] = $row;
}

echo json_encode($decks);

$stmt->close();
$conn->close();
?>
