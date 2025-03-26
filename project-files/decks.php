<?php include 'auth_check.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Decks</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://db.onlinewebfonts.com/c/01173b246d9d9ea808ea75a26b3b61bb?family=CircularSpotifyTxT-Black" rel="stylesheet">
</head>
<body class="weird-body">
  <div class="container">
    <div class="sidebar">
      <div class="logo">字</div>
      <nav>
        <ul>
          <li><a href="index.html">家</a></li>
          <li><a href="decks.html" class="active">📋</a></li>
          <li><a href="#" id="addDeckBtn">➕</a></li>
        </ul>
      </nav>
    </div>
    <main class="weird-body">
      <header class="header">
        <div class="search">
          <input type="text" class="search-bar" placeholder="⌕" style="font-family: 'CircularSpotifyTxT-Black'; font-size:x-large">
        </div>
        <div class="profile-icon" style="position: absolute; right: 0;border-radius: 25px;padding: 10px;background-color: #f4f4f4; cursor: pointer;">👤</div>
      </header>
      <h1 style="margin-left: 20%; margin-top:50px; margin-bottom: 20px;">Your Library</h1>
      <hr style="width: 68%; margin-left: 16%; height: 2px;">
      <div class="deck-container" id="deckContainer">
      </div>
    </main>
  </div>
  <!-- Deck Creation Modal -->
  <div id="deckModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2 class="add-deck-title">Create a New Deck</h2>
      <form class="add-deck-form" method="POST" enctype="multipart/form-data" action="submit_deck.php">
        <div class="form-group">
          <label for="deck-name">Deck Title:</label>
          <input type="text" id="deck-name" name="deck_name" placeholder="Enter deck title" required>
        </div>
        <div class="form-group">
          <label for="description">Deck Overview:</label>
          <textarea id="description" name="description" rows="2" placeholder="Brief description"></textarea>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label for="category">Category:</label>
            <select id="category" name="category">
              <option value="everyday">Everyday</option>
              <option value="business">Business</option>
              <option value="anime">Anime</option>
              <option value="custom">Custom</option>
            </select>
          </div>
          <div class="form-group">
            <label for="level">Language Level:</label>
            <select id="level" name="level">
              <option value="beginner">Beginner</option>
              <option value="intermediate">Intermediate</option>
              <option value="advanced">Advanced</option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label>Visibility:</label>
          <div class="radio-group">
            <label>
              <input type="radio" id="public" name="visibility" value="public" checked>
              Public
            </label>
            <label>
              <input type="radio" id="private" name="visibility" value="private">
              Private
            </label>
          </div>
        </div>        
        <div class="form-group">
          <label for="tags">Tags:</label>
          <input type="text" id="tags" name="tags" placeholder="e.g., vocabulary, grammar">
        </div>
        <div class="form-group">
          <label for="icon">Upload Deck Icon:</label>
          <input type="file" id="icon" name="deck_icon">
        </div>
        <button type="submit" class="add-deck-button">Create Deck</button>
      </form>
    </div>
  </div>
  
  <script src="index.js"></script>
</body>
</html>
