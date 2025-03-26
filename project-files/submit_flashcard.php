<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kanji = $_POST["kanji"] ?? "";
    $reading = $_POST["reading"] ?? "";
    $meaning = $_POST["meaning"] ?? "";
    $deck_id = $_POST["deck_id"] ?? "";

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
    $stmt = $conn->prepare("INSERT INTO flashcards (kanji, reading, meaning, deck_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $kanji, $reading, $meaning, $deck_id);

    if ($stmt->execute()) {
        echo "Flashcard added successfully!";
    } else {
        echo "Error adding flashcard.";
    }

    $stmt->close();
    $conn->close();
}
?>
