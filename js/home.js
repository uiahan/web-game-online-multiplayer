// Micro-interactions and subtle effects
document.querySelectorAll(".game-card").forEach((card) => {
  card.addEventListener("mouseenter", () => {
    // Potential for dynamic JS-driven animation trigger
  });
});

// Simple scroll reveal observer
const observerOptions = {
  threshold: 0.1,
};

const observer = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      entry.target.classList.add("opacity-100", "translate-y-0");
      entry.target.classList.remove("opacity-0", "translate-y-10");
    }
  });
}, observerOptions);

// Apply a subtle fade-in to major sections
document.querySelectorAll("section").forEach((section) => {
  section.classList.add(
    "transition-all",
    "duration-700",
    "ease-out",
    "opacity-0",
    "translate-y-10",
  );
  observer.observe(section);
});
