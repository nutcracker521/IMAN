<?php
header("Content-Type: application/json");
require 'db_connection.php';  // Ensure you have a separate database connection file

$sql = "SELECT id, deck_name, description, category, level, visibility, tags, deck_icon FROM decks";
$result = $conn->query($sql);

$decks = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $decks[] = $row;
    }
}

echo json_encode($decks);
$conn->close();
?>
