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
  const modal = document.getElementById("addDeckModal");
  const addButton = document.getElementById("addDeckBtn"); // Use correct ID
  const closeButton = document.querySelector(".close");

  addButton.addEventListener("click", function (event) {
      event.preventDefault();
      modal.style.display = "block"; // Show modal
  });

  closeButton.addEventListener("click", function () {
      modal.style.display = "none"; // Hide modal
  });

  window.addEventListener("click", function (event) {
      if (event.target === modal) {
          modal.style.display = "none"; // Hide modal if clicking outside
      }
  });
});
