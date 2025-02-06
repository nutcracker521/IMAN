<?php

$servername = "localhost";
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$dbname = "vocab_builder"; // Change this to your preferred database name

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully or already exists.<br>";
} else {
    die("Error creating database: " . $conn->error);
}


$conn->select_db($dbname);

$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'users' created successfully or already exists.<br>";
} else {
    die("Error creating table: " . $conn->error);
}

$sql = "CREATE TABLE IF NOT EXISTS posts (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11) NOT NULL,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'posts' created successfully or already exists.<br>";
} else {
    die("Error creating table: " . $conn->error);
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kanji Flashcards</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <div class="sidebar">
      <div class="logo">字</div>
      <nav>
        <ul>
          <li><a href="#" class="active">家</a></li>
          <li><a href="#">📋</a></li>
          <li><a href="#">➕</a></li>
        </ul>
      </nav>
    </div>
    <main>
      <header class="header">
        <div class="search">
          <input type="text" class="search-bar" placeholder="search in this deck">
        </div>
        <div class="profile-icon" style="position: absolute; right: 0;border-radius: 25px;padding: 10px;background-color: #f4f4f4; cursor: pointer;">👤</div>
      </header>
      <section class="content">
        <h1 style="font-size: xx-large; color: black;">Kanji</h2>
        <div class="buttons">
          <button class="btn">Learn</button>
          <button class="btn">Add</button>
          <button class="btn">Delete</button>
        </div>
        <h3 style="margin-top: 50px; margin-bottom: 50px; font-size: x-large; color: black;">Entries</h3>
        <div class="group">
          <div class="entries">
            <div class="entries-box" data-meaning="にち / ひ (sun, day)">日</div>
            <div class="entries-box" data-meaning="げつ / つき (moon, month)">月</div>
            <div class="entries-box" data-meaning="すい / みず (water)">水</div>
            <div class="entries-box" data-meaning="か / ひ (fire)">火</div>
            <div class="entries-box" data-meaning="もく / き (tree, wood)">木</div>
          </div>
        </div>
      </section>
    </main>
  </div>
  <script src="index.js"></script>
</body>
</html>
