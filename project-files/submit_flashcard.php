<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Content-Type: text/plain");

session_start();
require 'config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kanji = $_POST["kanji"] ?? "";
    $reading = $_POST["reading"] ?? "";
    $meaning = $_POST["meaning"] ?? "";
    $deck_id = $_POST["deck_id"] ?? "";
    $user_id = $_SESSION["user_id"] ?? 0;

    if (!$kanji || !$reading || !$meaning || !$deck_id) {
        echo "Error: Missing fields!";
        exit;
    }

    // Connect to database
    $conn = new mysqli("localhost", "root", "", "deck_manager");
    if ($conn->connect_error) {
        echo "Database connection failed!";
        exit;
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO flashcards (kanji, reading, meaning, deck_id, user_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssii", $kanji, $reading, $meaning, $deck_id, $user_id);

    if ($stmt->execute()) {
        echo "Flashcard added successfully!";
    } else {
        echo "Error adding flashcard.";
    }

    $stmt->close();
    $conn->close();
}
?>
