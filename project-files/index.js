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