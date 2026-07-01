<?php
session_start();

// Jika belum login, tendang ke halaman login
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}
?>

<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Whack-a-Mole Neon Arcade 🎮🐭</title>
    <style>
      /* --- DESAIN UI & TEMA ESTETIK NEON --- */
      :root {
        --bg-color: #0b0f19;
        --panel-bg: #1e1b4b;
        --primary-neon: #a855f7;
        --accent-neon: #22c55e;
        --danger-neon: #ef4444;
        --text-light: #f8fafc;
        --hole-dark: #020617;
      }

      body {
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        background-color: var(--bg-color);
        color: var(--text-light);
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        overflow: hidden;
      }

      header {
        text-align: center;
        margin-bottom: 20px;
      }

      header h1 {
        font-size: 2.2rem;
        margin: 0;
        color: var(--primary-neon);
        text-shadow: 0 0 15px rgba(168, 85, 247, 0.5);
        letter-spacing: 2px;
      }

      header p {
        margin: 5px 0 0 0;
        color: #94a3b8;
        font-size: 0.95rem;
      }

      /* DASHBOARD SKOR & KONTROL */
      .dashboard {
        background-color: var(--panel-bg);
        border: 2px solid rgba(168, 85, 247, 0.2);
        border-radius: 20px;
        padding: 15px 30px;
        display: flex;
        align-items: center;
        gap: 40px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        margin-bottom: 25px;
      }

      .stat-box {
        text-align: center;
      }

      .stat-label {
        font-size: 0.8rem;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 2px;
      }

      .stat-value {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--text-light);
      }

      #score {
        color: var(--accent-neon);
      }
      #time-left {
        color: var(--danger-neon);
      }

      .start-btn {
        padding: 12px 28px;
        font-size: 1rem;
        font-weight: bold;
        background: linear-gradient(135deg, #a855f7 0%, #6366f1 100%);
        color: var(--text-light);
        border: none;
        border-radius: 30px;
        cursor: pointer;
        box-shadow: 0 5px 15px rgba(168, 85, 247, 0.4);
        transition:
          transform 0.1s,
          opacity 0.2s;
      }

      .start-btn:hover {
        transform: scale(1.03);
        filter: brightness(1.1);
      }

      .start-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
      }

      /* GRID ARENA LUBANG */
      .arena-grid {
        display: grid;
        grid-template-columns: repeat(3, 150px);
        gap: 25px;
        padding: 20px;
        background-color: rgba(30, 27, 75, 0.3);
        border-radius: 24px;
        border: 1px solid rgba(255, 255, 255, 0.05);
      }

      /* LUBANG TIKUS (Sekarang dipasang fungsi klik di sini) */
      .hole {
        width: 150px;
        height: 150px;
        background-color: var(--hole-dark);
        border: 6px solid #312e81;
        border-radius: 50%;
        position: relative;
        overflow: hidden;
        box-shadow:
          inset 0 12px 20px rgba(0, 0, 0, 0.8),
          0 4px 10px rgba(0, 0, 0, 0.3);
        cursor: pointer; /* Kursor berubah saat di atas lubang */
      }

      /* KARAKTER TIKUS CYBERPUNK */
      .mole {
        width: 86%;
        height: 86%;
        background: linear-gradient(180deg, #6b21a8 0%, #4c1d95 100%);
        border-radius: 50% 50% 15px 15px;
        position: absolute;
        top: 100%;
        left: 7%;
        pointer-events: none; /* MEMBUAT KLIK TEMBUS LANGSUNG KE LUBANG */
        transition: top 0.12s cubic-bezier(0.175, 0.885, 0.32, 1.15);
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 4.5rem;
        user-select: none;
        box-shadow: 0 -4px 15px rgba(168, 85, 247, 0.3);
        border: 3px solid rgba(255, 255, 255, 0.1);
      }

      .mole::before,
      .mole::after {
        content: "";
        position: absolute;
        width: 32px;
        height: 32px;
        background-color: #4c1d95;
        border: 3px solid rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        top: -12px;
        z-index: -1;
      }
      .mole::before {
        left: 6px;
      }
      .mole::after {
        right: 6px;
      }

      .hole.up .mole {
        top: 18%;
      }

      .mole.bonked {
        animation: shake 0.15s ease-in-out;
        background: #22c55e !important;
      }

      @keyframes shake {
        0%,
        100% {
          transform: translateX(0);
        }
        25% {
          transform: translateX(-6px);
        }
        75% {
          transform: translateX(6px);
        }
      }
    </style>
  </head>
  <body>
    <button
      onclick="
        window.history.length > 1
          ? window.history.back()
          : (window.location.href = 'index.php')
      "
      style="
        position: fixed;
        top: 16px;
        left: 16px;
        z-index: 9999;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: none;
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(8px);
        cursor: pointer;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        font-size: 18px;
      "
    >
      ✕
    </button>
    <header>
      <h1>NEON WHACK-A-MOLE</h1>
      <p>
        Lebih santai! Cukup klik area lubang saat tikus muncul untuk cetak poin!
      </p>
    </header>

    <div class="dashboard">
      <div class="stat-box">
        <div class="stat-label">Skor Kamu</div>
        <div id="score" class="stat-value">0</div>
      </div>

      <button id="start-btn" class="start-btn" onclick="initGame()">
        MULAI GAME
      </button>

      <div class="stat-box">
        <div class="stat-label">Sisa Waktu</div>
        <div id="time-left" class="stat-value">20</div>
      </div>
    </div>

    <div class="arena-grid">
      <div class="hole" id="h1" onclick="bonk(this)">
        <div class="mole">🐭</div>
      </div>
      <div class="hole" id="h2" onclick="bonk(this)">
        <div class="mole">🐭</div>
      </div>
      <div class="hole" id="h3" onclick="bonk(this)">
        <div class="mole">🐭</div>
      </div>
      <div class="hole" id="h4" onclick="bonk(this)">
        <div class="mole">🐭</div>
      </div>
      <div class="hole" id="h5" onclick="bonk(this)">
        <div class="mole">🐭</div>
      </div>
      <div class="hole" id="h6" onclick="bonk(this)">
        <div class="mole">🐭</div>
      </div>
    </div>

    <script>
      const holes = document.querySelectorAll(".hole");
      const scoreDisplay = document.getElementById("score");
      const timeLeftDisplay = document.getElementById("time-left");
      const startBtn = document.getElementById("start-btn");

      let currentScore = 0;
      let timeRemaining = 20;
      let lastHole = null;
      let isGameRunning = false;
      let moleTimeout = null;
      let countdownInterval = null;

      function getRandomHole() {
        const index = Math.floor(Math.random() * holes.length);
        const hole = holes[index];
        if (hole === lastHole) {
          return getRandomHole();
        }
        lastHole = hole;
        return hole;
      }

      function spawnMole() {
        if (!isGameRunning) return;

        const currentHole = getRandomHole();
        currentHole.classList.add("up");

        // --- PERUBAHAN: Durasi tikus nongol dibikin lebih lama dan santai ---
        const minTime = 900; // Tikus minimal nongol hampir 1 detik
        const maxTime = 1400; // Maksimal jalan di tempat 1.4 detik
        const activeDuration = Math.random() * (maxTime - minTime) + minTime;

        moleTimeout = setTimeout(() => {
          currentHole.classList.remove("up");

          const moleElement = currentHole.querySelector(".mole");
          moleElement.classList.remove("bonked");
          moleElement.textContent = "🐭";

          if (isGameRunning) spawnMole();
        }, activeDuration);
      }

      // --- PERUBAHAN: Klik dideteksi langsung di wadah lubangnya ---
      function bonk(holeElement) {
        const moleElement = holeElement.querySelector(".mole");

        // Hanya dihitung poin kalau lubangnya emang lagi ada tikus naik & belum digebuk
        if (
          !holeElement.classList.contains("up") ||
          moleElement.classList.contains("bonked")
        )
          return;

        currentScore++;
        scoreDisplay.textContent = currentScore;

        moleElement.classList.add("bonked");
        moleElement.textContent = "💥";

        setTimeout(() => {
          holeElement.classList.remove("up");
        }, 100);
      }

      function initGame() {
        if (isGameRunning) return;

        currentScore = 0;
        timeRemaining = 20;
        isGameRunning = true;

        scoreDisplay.textContent = currentScore;
        timeLeftDisplay.textContent = timeRemaining;
        startBtn.disabled = true;

        holes.forEach((h) => {
          h.classList.remove("up");
          const m = h.querySelector(".mole");
          m.classList.remove("bonked");
          m.textContent = "🐭";
        });

        spawnMole();

        countdownInterval = setInterval(() => {
          timeRemaining--;
          timeLeftDisplay.textContent = timeRemaining;

          if (timeRemaining <= 0) {
            endTheGame();
          }
        }, 1000);
      }

      function endTheGame() {
        isGameRunning = false;
        clearInterval(countdownInterval);
        clearTimeout(moleTimeout);

        startBtn.disabled = false;
        holes.forEach((h) => h.classList.remove("up"));

        setTimeout(() => {
          alert(`🎮 GAME OVER!\nSkor Akhir Refleksmu: ${currentScore} Poin.`);
        }, 250);
      }
    </script>
  </body>
</html>
