<?php
require "db_connection.php"; // Ensure DB connection is established

$deck_id = $_GET['deck_id'] ?? null;

if (!$deck_id) {
    echo json_encode(["error" => "No deck ID provided"]);
    exit;
}

$stmt = $conn->prepare("SELECT deck_name FROM decks WHERE id = ?");
$stmt->bind_param("i", $deck_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

echo json_encode($result);
?>
