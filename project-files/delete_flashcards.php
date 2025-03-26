<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!isset($_POST['ids']) || empty($_POST['ids'])) {
        die("No IDs received.");
    }

    $ids = explode(",", $_POST['ids']);
    echo "Received IDs: " . implode(", ", $ids); // Debugging output

    // Database connection
    $conn = new mysqli("localhost", "root", "", "deck_manager");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Convert IDs into a safe SQL query
    $ids_str = implode(",", array_map('intval', $ids));
    $query = "DELETE FROM flashcards WHERE id IN ($ids_str)";

    if ($conn->query($query) === TRUE) {
        echo "Deletion successful";
    } else {
        echo "Error deleting flashcards: " . $conn->error;
    }

    $conn->close();
}
?>
