// Password Visibility Toggle Interaction
const passwordInput = document.getElementById("password");
const toggleBtn = document.getElementById("togglePassword");

if (toggleBtn) {
  toggleBtn.addEventListener("click", () => {
    const isPassword = passwordInput.type === "password";
    passwordInput.type = isPassword ? "text" : "password";
    toggleBtn.textContent = isPassword ? "visibility_off" : "visibility";
  });
}

// Simple Form Submission Micro-interaction
const loginForm = document.getElementById("loginForm");
loginForm.addEventListener("submit", (e) => {
  const btn = loginForm.querySelector('button[type="submit"]');
  const originalContent = btn.innerHTML;

  btn.disabled = true;
  btn.innerHTML = `<span class="material-symbols-outlined animate-spin">refresh</span> <span>Sedang Masuk...</span>`;

  setTimeout(() => {
    btn.innerHTML = `<span class="material-symbols-outlined">check_circle</span> <span>Berhasil!</span>`;
    btn.classList.remove("bg-primary");
    btn.classList.add("bg-tertiary");

    setTimeout(() => {
      btn.disabled = false;
      btn.innerHTML = originalContent;
      btn.classList.add("bg-primary");
      btn.classList.remove("bg-tertiary");
    }, 2000);
  }, 1500);
});

// Atmospheric floating mouse effect for background
document.addEventListener("mousemove", (e) => {
  const moveX = (e.clientX - window.innerWidth / 2) / 50;
  const moveY = (e.clientY - window.innerHeight / 2) / 50;
  document.body.style.backgroundPosition = `${moveX}px ${moveY}px`;
});
