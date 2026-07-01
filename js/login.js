// Password Visibility Toggle
const passwordInput = document.getElementById("password");
const toggleBtn = document.getElementById("togglePassword");

if (toggleBtn) {
  toggleBtn.addEventListener("click", () => {
    const isPassword = passwordInput.type === "password";
    passwordInput.type = isPassword ? "text" : "password";
    toggleBtn.textContent = isPassword ? "visibility_off" : "visibility";
  });
}

// Form Submission dengan AJAX (Fetch)
const loginForm = document.getElementById("loginForm");
if (loginForm) {
  loginForm.addEventListener("submit", (e) => {
    e.preventDefault(); // Mencegah pindah halaman otomatis

    const btn = loginForm.querySelector('button[type="submit"]');
    const originalContent = btn.innerHTML;

    // 1. Tampilkan animasi loading
    btn.disabled = true;
    btn.innerHTML = `<span class="material-symbols-outlined animate-spin">refresh</span> <span>Sedang Masuk...</span>`;

    const formData = new FormData(loginForm);

    // 2. Kirim data ke PHP
    fetch('koneksi/login.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.status === 'success') {
        Swal.fire({
          icon: 'success',
          title: 'Berhasil!',
          text: data.message,
          timer: 1500,
          showConfirmButton: false
        }).then(() => {
          window.location.href = '../index.php'; // Pindah halaman
        });
      } else {
        // 3. Reset jika gagal
        btn.disabled = false;
        btn.innerHTML = originalContent;
        
        Swal.fire({
          icon: 'error',
          title: 'Gagal',
          text: data.message
        });
      }
    })
    .catch(() => {
      btn.disabled = false;
      btn.innerHTML = originalContent;
      Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi masalah koneksi.' });
    });
  });
}

// Atmospheric floating mouse effect
document.addEventListener("mousemove", (e) => {
  const moveX = (e.clientX - window.innerWidth / 2) / 50;
  const moveY = (e.clientY - window.innerHeight / 2) / 50;
  document.body.style.backgroundPosition = `${moveX}px ${moveY}px`;
});