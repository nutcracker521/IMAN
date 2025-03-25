<?php
require "db_connection.php"; // Ensure you have a working DB connection

$deck_id = $_GET['deck_id'] ?? null;

if (!$deck_id) {
    echo json_encode(["error" => "No deck ID provided"]);
    exit;
}

$stmt = $conn->prepare("SELECT kanji, reading, meaning FROM flashcards WHERE deck_id = ?");
$stmt->bind_param("i", $deck_id);
$stmt->execute();
$result = $stmt->get_result();

$flashcards = [];
while ($row = $result->fetch_assoc()) {
    $flashcards[] = $row;
}

echo json_encode($flashcards);
?>
