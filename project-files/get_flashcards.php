<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$user_id = $_SESSION['user_id'];
$deck_id = $_GET['deck_id'];

//echo json_encode(["user_id" => $_SESSION['user_id']]);

$stmt = $conn->prepare("SELECT kanji, reading, meaning FROM flashcards WHERE deck_id = ? AND user_id = ?");
$stmt->bind_param("ii", $deck_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

$flashcards = [];
while ($row = $result->fetch_assoc()) {
    $flashcards[] = $row;
}

echo json_encode($flashcards);

$stmt->close();
$conn->close();
?>
