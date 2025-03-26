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
  const modal2 = document.getElementById("deckModal");
  const addDeckBtn = document.getElementById("addDeckBtn");
  const closeModal2 = document.querySelector(".close");

  modal2.style.display = "none"; 

  if (addDeckBtn && modal2) {
    addDeckBtn.addEventListener("click", function () {
      modal2.style.display = "block";
    });
  }

  if (closeModal2) {
    closeModal2.addEventListener("click", function () {
      modal2.style.display = "none";
    });
  }

  window.addEventListener("click", function (event) {
    if (event.target === modal2) {
      modal2.style.display = "none";
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
      if (!deckContainer) {
        console.error("Error: deck-container not found.");
        return;
      }

      deckContainer.innerHTML = ""; // Clear existing content

      data.forEach(deck => {
        const deckButton = document.createElement("button");
        deckButton.classList.add("deck-button");

        deckButton.innerHTML = `
          <div class="deck-content">
            <span class="deck-title">📍 ${deck.deck_name}</span>
            <small class="deck-info">${deck.category} | ${deck.level}</small>
          </div>
        `;

        // Use 'tid' if 'id' is incorrect
        deckButton.setAttribute("data-id", deck.tid || deck.id);

        // Click event to redirect with deck ID
        deckButton.addEventListener("click", () => {
          window.location.href = `index.php?deck_id=${deck.tid || deck.id}`;
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
      if (!entriesContainer) {
        console.error("Error: entries container not found.");
        return;
      }

      entriesContainer.innerHTML = ""; // Clear previous content

      // Check if `data` is an array
      if (!Array.isArray(data) || data.length === 0) {
        entriesContainer.innerHTML = `<div class="no-entries" style="font-family: "CircularSpotifyTxT-Black"; color: black;">No flashcards found.</div>`;
        return;
      }

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

document.addEventListener("DOMContentLoaded", function () {
  const deleteBtn = document.querySelector(".delete-btn");
  const modal = document.getElementById("deleteModal");
  const closeModal = document.getElementById("closeModal");
  const confirmDelete = document.getElementById("confirmDelete");

  modal.style.display = "none"

  const urlParams = new URLSearchParams(window.location.search);
  const deckId = urlParams.get("deck_id");

  deleteBtn.addEventListener("click", () => openDeleteModal(deckId));
  closeModal.addEventListener("click", () => modal.style.display = "none");
  confirmDelete.addEventListener("click", deleteSelectedFlashcards);
});

function openDeleteModal(deckId) {
  const modal = document.getElementById("deleteModal");
  const deleteEntriesContainer = document.getElementById("deleteEntries");
  deleteEntriesContainer.innerHTML = ""; // Clear previous content

  modal.style.display = "block";


  fetch(`get_flashcards.php?deck_id=${deckId}`) // Fetch all flashcards
      .then(response => response.json())
      .then(data => {
          console.log("Fetched data:", data);
          data.forEach(flashcard => {
              const entry = document.createElement("div");
              entry.classList.add("delete-entry");

              const checkbox = document.createElement("input");
              checkbox.type = "checkbox";
              checkbox.value = flashcard.id;

              const text = document.createElement("span");
              text.textContent = flashcard.kanji + " - " + flashcard.reading;

              entry.appendChild(checkbox);
              entry.appendChild(text);
              deleteEntriesContainer.appendChild(entry);
          });

          modal.style.display = "flex"; // Show modal
      })
      .catch(error => console.error("Error fetching flashcards:", error));
}

function deleteSelectedFlashcards() {
  const selectedIds = [...document.querySelectorAll("#deleteEntries input:checked")]
      .map(checkbox => checkbox.value);

  if (selectedIds.length === 0) {
      alert("No flashcards selected.");
      return;
  }

  fetch("delete_flashcards.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: "ids=" + selectedIds.join(",")
  })
  .then(response => response.text())
  .then(data => {
      alert(data);
      location.reload(); // Reload the page to update UI
  })
  .catch(error => console.error("Error deleting flashcards:", error));
}

/*MY ATTEMPT*/

document.addEventListener("DOMContentLoaded", function () {
  const addFlashcardBtn = document.getElementById("addFlashcardBtn"); // Button to open modal
  const flashcardModal = document.getElementById("addflashcardModal"); // Modal itself
  const closeFlashcardModal = document.getElementById("closeAddModal"); // Cancel button
  const flashcardForm = document.getElementById("flashcardForm"); // Form inside modal

  // Ensure modal starts hidden
  if (flashcardModal) {
    flashcardModal.style.display = "none";
  }

  // Open the modal
  if (addFlashcardBtn) {
    addFlashcardBtn.addEventListener("click", function () {
      flashcardModal.style.display = "block";
    });
  }

  // Close the modal when clicking the "Cancel" button
  if (closeFlashcardModal) {
    closeFlashcardModal.addEventListener("click", function () {
      flashcardModal.style.display = "none";
    });
  }

  // Close modal if user clicks outside the modal
  window.addEventListener("click", function (event) {
    if (event.target === flashcardModal) {
      flashcardModal.style.display = "none";
    }
  });

  // Handle flashcard form submission
  if (flashcardForm) {
    flashcardForm.addEventListener("submit", function (event) {
      event.preventDefault(); // Prevent default form submission

      const formData = new FormData(flashcardForm);
      const urlParams = new URLSearchParams(window.location.search);
      const deckId = urlParams.get("deck_id");

      if (!deckId) {
        alert("No deck selected. Please select a deck first.");
        return;
      }

      formData.append("deck_id", deckId); // Attach deck ID

      fetch("submit_flashcard.php", {
        method: "POST",
        body: formData
      })
      .then(response => response.text())
      .then(data => {
        alert(data); // Show server response
        flashcardForm.reset(); // Clear form fields
        flashcardModal.style.display = "none"; // Hide modal
        loadFlashcards(deckId); // Refresh flashcard list
      })
      .catch(error => console.error("Error submitting flashcard:", error));
    });
  }
});





