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
