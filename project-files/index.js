document.addEventListener("DOMContentLoaded", () => {
  const flashcards = document.querySelectorAll(".entries-box");

  flashcards.forEach(card => {
      card.addEventListener("click", () => {
          if (card.classList.contains("revealed")) {
              card.innerHTML = card.dataset.kanji; // Hide meaning, show kanji
              card.classList.remove("revealed");
          } else {
              card.dataset.kanji = card.innerHTML; // Store kanji
              card.innerHTML = card.dataset.meaning; // Show meaning
              card.classList.add("revealed");
          }
      });
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const modal = document.getElementById("deckModal");
  const addDeckBtn = document.getElementById("addDeckBtn");
  const closeModal = document.querySelector(".close");

  modal.style.display = "none"; 

  if (addDeckBtn && modal) {
    addDeckBtn.addEventListener("click", function () {
      modal.style.display = "block";
    });
  }

  if (closeModal) {
    closeModal.addEventListener("click", function () {
      modal.style.display = "none";
    });
  }

  window.addEventListener("click", function (event) {
    if (event.target === modal) {
      modal.style.display = "none";
    }
  });
});


document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector(".add-deck-form");

  form.addEventListener("submit", function (event) {
    event.preventDefault();

    let formData = new FormData(form);

    fetch("http://localhost/project-files/submit_deck.php", {
      method: "POST",
      body: formData
    })    
    .then(response => response.text())
    .then(data => {
      alert(data); // Show response from PHP
      form.reset(); // Clear form after successful submission
    })
    .catch(error => console.error("Error:", error));
  });
});

document.addEventListener("DOMContentLoaded", function () {
  fetchDecks();
});

function fetchDecks() {
  fetch("get_decks.php")
    .then(response => response.json())
    .then(data => {
      const deckContainer = document.querySelector(".deck-container");
      deckContainer.innerHTML = ""; // Clear existing content

      data.forEach(deck => {
        const deckButton = document.createElement("button");
        deckButton.classList.add("deck-button");

        deckButton.innerHTML = `
          <span>📍 ${deck.deck_name}</span>
          <small>${deck.category} | ${deck.level}</small>
        `;

        // Set a unique ID or name attribute
        deckButton.setAttribute("data-id", deck.id); 

        // Click event to redirect to index.html with deck ID
        deckButton.addEventListener("click", () => {
          window.location.href = `index.html?deck_id=${deck.id}`;
        });

        deckContainer.appendChild(deckButton);
      });
    })
    .catch(error => console.error("Error fetching decks:", error));
}

document.addEventListener("DOMContentLoaded", function () {
  const urlParams = new URLSearchParams(window.location.search);
  const deckId = urlParams.get("deck_id");

  if (deckId) {
      console.log(`Loading flashcards for deck ID: ${deckId}`);
      fetchDeckDetails(deckId);
      loadFlashcards(deckId);
  } else {
      console.warn("No deck selected.");
  }
});

// Fetch the deck name to display on the page
function fetchDeckDetails(deckId) {
  fetch(`get_deck_info.php?deck_id=${deckId}`)
      .then(response => response.json())
      .then(deck => {
          document.querySelector("h1").textContent = deck.deck_name || "Kanji";
      })
      .catch(error => console.error("Error fetching deck details:", error));
}

// Fetch and display flashcards
function loadFlashcards(deckId) {
  fetch(`get_flashcards.php?deck_id=${deckId}`)
      .then(response => response.json())
      .then(data => {
          const entriesContainer = document.querySelector(".entries");
          entriesContainer.innerHTML = ""; // Clear previous content

          data.forEach(flashcard => {
              const card = document.createElement("div");
              card.classList.add("entries-box");
              card.setAttribute("data-meaning", `${flashcard.reading} (${flashcard.meaning})`);
              card.textContent = flashcard.kanji;
              entriesContainer.appendChild(card);
          });
      })
      .catch(error => console.error("Error fetching flashcards:", error));
}

