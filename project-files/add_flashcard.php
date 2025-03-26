<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$user_id = $_SESSION['user_id'];
$deck_id = $_POST['deck_id'];
$question = trim($_POST['question']);
$answer = trim($_POST['answer']);

// Ensure the deck belongs to the user
$check_stmt = $conn->prepare("SELECT id FROM decks WHERE id = ? AND user_id = ?");
$check_stmt->bind_param("ii", $deck_id, $user_id);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows === 0) {
    echo json_encode(["status" => "error", "message" => "Unauthorized action."]);
    exit;
}

$check_stmt->close();

// Insert flashcard
$stmt = $conn->prepare("INSERT INTO flashcards (question, answer, deck_id, user_id) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssii", $question, $answer, $deck_id, $user_id);

if ($stmt->execute()) {
    echo json_encode(["status" => "success", "flashcard_id" => $stmt->insert_id]);
} else {
    echo json_encode(["status" => "error"]);
}

$stmt->close();
$conn->close();
?>
