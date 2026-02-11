// File: js/script.js

document.addEventListener("DOMContentLoaded", () => {
  console.log("Script loaded. Ready to enhance UI interactions.");

  // Example: Smooth scroll for nav links
  document.querySelectorAll("nav a").forEach(link => {
    link.addEventListener("click", (e) => {
      const target = e.target.getAttribute("href");
      if (target.startsWith("#")) {
        e.preventDefault();
        document.querySelector(target).scrollIntoView({ behavior: "smooth" });
      }
    });
  });

  // Optional: Add dark mode toggle (future)
  // const toggleBtn = document.getElementById("dark-mode-toggle");
});
