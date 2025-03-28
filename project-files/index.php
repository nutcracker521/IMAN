<?php include 'auth_check.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kanji Flashcards</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://db.onlinewebfonts.com/c/01173b246d9d9ea808ea75a26b3b61bb?family=CircularSpotifyTxT-Black" rel="stylesheet">
</head>
<body>
  <div class="container">
    <div class="sidebar">
      <div class="logo">字</div>
      <nav>
        <ul>
          <li><a href="decks.php" class="active">家</a></li>
          <li><a href="decks.php">📋</a></li>
          <li><a href="#" id="addDeckBtn">➕</a></li>
        </ul>
      </nav>
    </div>
    <main>
      <header class="header">
        <div class="search">
          <input type="text" class="search-bar" placeholder="Search in this deck">
        </div>
        <div class="profile-icon" style="position: absolute; right: 0; border-radius: 25px; padding: 10px; background-color: #f4f4f4; cursor: pointer;">👤</div>
      </header>
      <section class="content">
        <h1 style="font-size: xx-large; color: black; margin-bottom: 25px;">Kanji</h1>
        <hr style="width: 100%; height: 2px; margin-bottom: 25px;">
        <div class="buttons">
          <button class="btn">Learn</button>
          <button class="btn" id="addFlashcardBtn">Add</button>
          <button class="btn delete-btn">Delete</button>
        </div>
        <h3 style="margin-top: 50px; margin-bottom: 25px; font-size: x-large; color: black;">Entries</h3>
        <hr style="width: 100%; height: 2px; margin-bottom: 25px;">
        <div class="group">
          <div class="entries"> 
          </div>
        </div>
      </section>
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

  <div id="addflashcardModal" class="modal">
    <div class="modal-content">
        <h2>Add a Flashcard</h2>
        <form id="flashcardForm">
            <label for="kanjiInput">Kanji:</label>
            <input type="text" id="kanjiInput" name="kanji" placeholder="Enter Kanji" required>

            <label for="readingInput">Reading:</label>
            <input type="text" id="readingInput" name="reading" placeholder="Enter Reading" required>

            <label for="meaningInput">Meaning:</label>
            <input type="text" id="meaningInput" name="meaning" placeholder="Enter Meaning" required>

            <button type="submit" id="submitFlashcardBtn">Add Flashcard</button>
            <button type="button" id="closeAddModal">Cancel</button>
        </form>
    </div>
  </div>

  <div id="deleteModal" class="modal">
    <div class="modal-content">
        <h2>Select Flashcards to Delete</h2>
        <div id="deleteEntries"></div>
        <button id="confirmDelete">Confirm Delete</button>
        <button id="closeModal">Cancel</button>
    </div>
</div>

  <script src="index.js"></script>
</body>
</html>
