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
    <title>Futsal Penalty</title>
    <style>
      /* --- DESAIN UI & TEMA ESTETIK --- */
      :root {
        --bg-color: #0f172a;
        --panel-bg: #1e293b;
        --primary-neon: #38bdf8;
        --accent-gold: #f59e0b;
        --turf-green: #10b981;
        --danger-neon: #f43f5e;
        --text-light: #f8fafc;
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
        margin-bottom: 15px;
        z-index: 5;
      }

      header h1 {
        font-size: 2.2rem;
        margin: 0;
        color: var(--primary-neon);
        text-shadow: 0 0 12px rgba(56, 189, 248, 0.4);
        letter-spacing: 1px;
      }

      header p {
        margin: 5px 0 0 0;
        color: #94a3b8;
        font-size: 0.95rem;
      }

      /* SCREEN 1: LOBBY UTAMA */
      #lobby-screen {
        background-color: var(--panel-bg);
        padding: 40px;
        border-radius: 24px;
        border: 2px solid rgba(56, 189, 248, 0.2);
        text-align: center;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5);
        max-width: 420px;
        width: 90%;
        transition: all 0.3s ease;
      }

      #lobby-screen h2 {
        font-size: 1.5rem;
        margin-top: 0;
        margin-bottom: 25px;
        color: var(--text-light);
      }

      .role-card {
        background: linear-gradient(135deg, #334155 0%, #1e293b 100%);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 15px;
        cursor: pointer;
        transition:
          transform 0.2s,
          border-color 0.2s;
        display: flex;
        align-items: center;
        justify-content: space-between;
      }

      .role-card:hover {
        transform: translateY(-3px);
        border-color: var(--primary-neon);
        box-shadow: 0 8px 20px rgba(56, 189, 248, 0.15);
      }

      .role-info {
        text-align: left;
      }

      .role-title {
        font-size: 1.15rem;
        font-weight: bold;
        color: var(--text-light);
        margin-bottom: 4px;
      }

      .role-desc {
        font-size: 0.85rem;
        color: #94a3b8;
      }

      .role-icon {
        font-size: 2rem;
      }

      /* SCREEN 2: IN-GAME CONTAINER */
      #game-container {
        display: none;
        position: relative;
      }

      /* Papan Skor Atas */
      .scoreboard {
        background-color: var(--panel-bg);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-bottom: none;
        border-radius: 16px 16px 0 0;
        padding: 12px 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: bold;
      }

      .score-box {
        display: flex;
        gap: 15px;
        font-size: 1.1rem;
      }

      .score-box span {
        color: var(--accent-gold);
      }

      .role-badge {
        background-color: rgba(56, 189, 248, 0.1);
        color: var(--primary-neon);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
      }

      canvas {
        background-color: #065f46; /* Hijau Futsal gelap eksklusif */
        border: 4px solid var(--panel-bg);
        border-top: none;
        border-radius: 0 0 16px 16px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        display: block;
        cursor: crosshair;
      }

      /* OVERLAY NOTIFIKASI HASIL */
      #result-overlay {
        display: none;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(15, 23, 42, 0.75);
        border-radius: 0 0 16px 16px;
        backdrop-filter: blur(4px);
        z-index: 10;
        align-items: center;
        justify-content: center;
        flex-direction: column;
      }

      #result-box {
        background-color: var(--panel-bg);
        padding: 30px 40px;
        border-radius: 20px;
        border: 2px solid rgba(255, 255, 255, 0.1);
        text-align: center;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.5);
        transform: scale(0.9);
        animation: popIn 0.25s forwards cubic-bezier(0.175, 0.885, 0.32, 1.275);
      }

      @keyframes popIn {
        to {
          transform: scale(1);
        }
      }

      #result-title {
        font-size: 2.2rem;
        margin-top: 0;
        margin-bottom: 20px;
        font-weight: 800;
      }

      .action-btn {
        padding: 12px 28px;
        font-size: 1rem;
        font-weight: bold;
        background-color: var(--primary-neon);
        color: var(--bg-color);
        border: none;
        border-radius: 30px;
        cursor: pointer;
        box-shadow: 0 5px 15px rgba(56, 189, 248, 0.3);
        transition:
          transform 0.1s,
          background-color 0.2s;
      }

      .action-btn:hover {
        background-color: #7dd3fc;
        transform: scale(1.03);
      }

      .action-btn:active {
        transform: scale(0.98);
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
      <h1>FUTSAL PENALTY</h1>
      <p>Arahkan sasaran bidik pinalti dengan akurat menggunakan kursor!</p>
    </header>

    <div id="lobby-screen">
      <h2>Pilih Posisi Bermain:</h2>

      <div class="role-card" onclick="startTheGame('kicker')">
        <div class="role-info">
          <div class="role-title">🏃‍♂️ Striker Eksekutor</div>
          <div class="role-desc">
            Tentukan target celah gawang dan cetak gol!
          </div>
        </div>
        <div class="role-icon">⚽</div>
      </div>

      <div class="role-card" onclick="startTheGame('gk')">
        <div class="role-info">
          <div class="role-title">🧤 Kiper Penyelamat</div>
          <div class="role-desc">
            Tepis dan baca arah tendangan pinalti bot.
          </div>
        </div>
        <div class="role-icon">🧤</div>
      </div>
    </div>

    <div id="game-container">
      <div class="scoreboard">
        <div class="score-box">
          <div>KAMU: <span id="p-score">0</span></div>
          <div>BOT: <span id="b-score">0</span></div>
        </div>
        <div id="badge-display" class="role-badge">STRIKER</div>
      </div>

      <canvas id="gameCanvas" width="480" height="580"></canvas>

      <div id="result-overlay">
        <div id="result-box">
          <h2 id="result-title">GOAL!</h2>
          <button class="action-btn" onclick="continueToNextRound()">
            Lanjut Babak
          </button>
        </div>
      </div>
    </div>

    <script>
      const canvas = document.getElementById("gameCanvas");
      const ctx = canvas.getContext("2d");
      const lobbyScreen = document.getElementById("lobby-screen");
      const gameContainer = document.getElementById("game-container");
      const resultOverlay = document.getElementById("result-overlay");
      const resultTitle = document.getElementById("result-title");
      const badgeDisplay = document.getElementById("badge-display");

      const pScoreDisplay = document.getElementById("p-score");
      const bScoreDisplay = document.getElementById("b-score");

      // Parameter Inti
      let myRole = "";
      let scorePlayer = 0;
      let scoreBot = 0;
      let gameState = "ready"; // ready, shooting, complete

      // Dimensi Gawang Realistis
      const goal = {
        x: 80,
        y: 90,
        width: 320,
        height: 130,
      };

      // Objek Bola Fisik
      const ball = {
        startX: 240,
        startY: 480,
        x: 240,
        y: 480,
        radius: 11,
        targetX: 240,
        targetY: 480,
        speed: 16,
      };

      // Objek Kiper Komputer / Player
      const goalkeeper = {
        x: 240,
        y: 160,
        width: 44,
        height: 65,
        targetX: 240,
        speed: 13,
      };

      // Sistem Mengaktifkan Lobby Game
      function startTheGame(chosenRole) {
        myRole = chosenRole;
        lobbyScreen.style.display = "none";
        gameContainer.style.display = "block";

        badgeDisplay.textContent = myRole === "kicker" ? "STRIKER" : "KIPER";

        refreshPositions();
        renderArena();
      }

      // Event Listener Klik pada Area Lapangan
      canvas.addEventListener("click", (event) => {
        if (gameState !== "ready") return;

        const rect = canvas.getBoundingClientRect();
        const clickX = event.clientX - rect.left;
        const clickY = event.clientY - rect.top;

        if (myRole === "kicker") {
          // Skenario Pemain Menembak Bola
          ball.targetX = clickX;
          ball.targetY = clickY;

          // Bot Kiper memilih 1 dari 3 blok refleks perlindungan gawang secara dinamis
          const aiChoices = [130, 240, 350];
          goalkeeper.targetX =
            aiChoices[Math.floor(Math.random() * aiChoices.length)];

          gameState = "shooting";
        } else if (myRole === "gk") {
          // Skenario Pemain Menjadi Kiper (Melompat ke Posisi Kursor X)
          goalkeeper.targetX = clickX;

          // Bot Penendang mengarahkan bola ke dalam gawang secara acak
          ball.targetX = Math.random() * (goal.width - 30) + goal.x + 15;
          ball.targetY = Math.random() * (goal.height - 25) + goal.y + 15;

          gameState = "shooting";
        }

        runShotAnimation();
      });

      // Loop Animasi Alur Bola & Pergerakan Kiper
      function runShotAnimation() {
        if (gameState !== "shooting") return;

        // Vektor Pergerakan Bola Lurus Akurat
        let dx = ball.targetX - ball.x;
        let dy = ball.targetY - ball.y;
        let distance = Math.sqrt(dx * dx + dy * dy);

        if (distance > ball.speed) {
          ball.x += (dx / distance) * ball.speed;
          ball.y += (dy / distance) * ball.speed;
        } else {
          ball.x = ball.targetX;
          ball.y = ball.targetY;
        }

        // Interpolasi Kecepatan Lompatan Kiper
        let gkDx = goalkeeper.targetX - goalkeeper.x;
        if (Math.abs(gkDx) > goalkeeper.speed) {
          goalkeeper.x += Math.sign(gkDx) * goalkeeper.speed;
        } else {
          goalkeeper.x = goalkeeper.targetX;
        }

        renderArena();

        // Selesai jika koordinat bola menyentuh titik target bidik
        if (ball.x === ball.targetX && ball.y === ball.targetY) {
          processScores();
          return;
        }

        requestAnimationFrame(runShotAnimation);
      }

      // Kalkulasi Deteksi Skor Gol / Penyelamatan (Tanpa Glitch)
      function processScores() {
        gameState = "complete";

        // Validasi apakah bola masuk ke kotak dimensi gawang
        let isInsideGoal =
          ball.x >= goal.x &&
          ball.x <= goal.x + goal.width &&
          ball.y >= goal.y &&
          ball.y <= goal.y + goal.height;

        // Validasi jangkauan blokade fisik tubuh kiper
        let isSavedByGK =
          ball.x >= goalkeeper.x - goalkeeper.width / 2 - 10 &&
          ball.x <= goalkeeper.x + goalkeeper.width / 2 + 10 &&
          ball.y >= goalkeeper.y - 15 &&
          ball.y <= goalkeeper.y + goalkeeper.height + 15;

        if (isInsideGoal && !isSavedByGK) {
          if (myRole === "kicker") {
            scorePlayer++;
            triggerModal("GOAL!! 🎉", "#10b981");
          } else {
            scoreBot++;
            triggerModal("KEBOBOLAN!! ⚽", "#f43f5e");
          }
        } else {
          if (myRole === "kicker") {
            scoreBot++;
            triggerModal("DITEPIS KIPER! 🧤", "#f43f5e");
          } else {
            scorePlayer++;
            triggerModal("NICE SAVE!! 🧤🔥", "#10b981");
          }
        }

        pScoreDisplay.textContent = scorePlayer;
        bScoreDisplay.textContent = scoreBot;
      }

      function triggerModal(msg, color) {
        resultTitle.textContent = msg;
        resultTitle.style.color = color;
        resultOverlay.style.display = "flex";
      }

      // Gambar Grafik Desain Game 2D Modern
      function renderArena() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        // 1. Lapangan Futsal & Marka Garis Putih Estetik
        ctx.fillStyle = "#0f766e";
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        ctx.strokeStyle = "rgba(255, 255, 255, 0.4)";
        ctx.lineWidth = 3;
        ctx.strokeRect(20, 20, canvas.width - 40, canvas.height - 20);

        // Busur Kotak Penalti Futsal Atas
        ctx.beginPath();
        ctx.arc(240, 20, 140, 0, Math.PI, false);
        ctx.stroke();

        // 2. Gawang & Jaring Transparan
        ctx.fillStyle = "rgba(56, 189, 248, 0.08)";
        ctx.fillRect(goal.x, goal.y, goal.width, goal.height);

        // Jaring Dekoratif
        ctx.strokeStyle = "rgba(255,255,255,0.15)";
        ctx.lineWidth = 1;
        for (let i = goal.x; i < goal.x + goal.width; i += 15) {
          ctx.beginPath();
          ctx.moveTo(i, goal.y);
          ctx.lineTo(i, goal.y + goal.height);
          ctx.stroke();
        }
        for (let j = goal.y; j < goal.y + goal.height; j += 15) {
          ctx.beginPath();
          ctx.moveTo(goal.x, j);
          ctx.lineTo(goal.x + goal.width, j);
          ctx.stroke();
        }

        // Tiang Gawang Tebal Putih
        ctx.strokeStyle = "#ffffff";
        ctx.lineWidth = 6;
        ctx.strokeRect(goal.x, goal.y, goal.width, goal.height);

        // 3. Karakter Kiper Modis
        ctx.fillStyle = "#38bdf8"; // Jersey Kiper Neon Cyan
        ctx.beginPath();
        ctx.roundRect(
          goalkeeper.x - goalkeeper.width / 2,
          goalkeeper.y,
          goalkeeper.width,
          goalkeeper.height,
          [12, 12, 4, 4],
        );
        ctx.fill();

        // Kepala Kiper
        ctx.fillStyle = "#fbcfe8";
        ctx.beginPath();
        ctx.arc(goalkeeper.x, goalkeeper.y - 12, 11, 0, Math.PI * 2);
        ctx.fill();

        // Sarung Tangan Kiper Kiri-Kanan Neon Gold
        ctx.fillStyle = "#f59e0b";
        ctx.beginPath();
        ctx.arc(
          goalkeeper.x - goalkeeper.width / 2 - 6,
          goalkeeper.y + 25,
          7,
          0,
          Math.PI * 2,
        );
        ctx.arc(
          goalkeeper.x + goalkeeper.width / 2 + 6,
          goalkeeper.y + 25,
          7,
          0,
          Math.PI * 2,
        );
        ctx.fill();

        // 4. Titik Putih Pinalti & Desain Bola Sepak Klasik
        ctx.fillStyle = "#ffffff";
        ctx.beginPath();
        ctx.arc(240, 480, 4, 0, Math.PI * 2);
        ctx.fill();

        // Menggambar Kerangka Luar Bola
        ctx.fillStyle = "#ffffff";
        ctx.beginPath();
        ctx.arc(ball.x, ball.y, ball.radius, 0, Math.PI * 2);
        ctx.fill();

        // Corak Panel Hexagonal Hitam Tengah Bola
        ctx.fillStyle = "#1e293b";
        ctx.beginPath();
        ctx.arc(ball.x, ball.y, 4, 0, Math.PI * 2);
        ctx.fill();
        ctx.beginPath();
        ctx.arc(ball.x - 6, ball.y - 4, 2, 0, Math.PI * 2);
        ctx.fill();
        ctx.beginPath();
        ctx.arc(ball.x + 6, ball.y - 4, 2, 0, Math.PI * 2);
        ctx.fill();
        ctx.beginPath();
        ctx.arc(ball.x - 4, ball.y + 5, 2, 0, Math.PI * 2);
        ctx.fill();
        ctx.beginPath();
        ctx.arc(ball.x + 4, ball.y + 5, 2, 0, Math.PI * 2);
        ctx.fill();
      }

      // Lanjut ke Ronde Berikutnya Tanpa Refresh Halaman
      function continueToNextRound() {
        resultOverlay.style.display = "none";
        refreshPositions();
        gameState = "ready";
        renderArena();
      }

      // Mengembalikan Posisi Bola dan Kiper ke Awal
      function refreshPositions() {
        ball.x = ball.startX;
        ball.y = ball.startY;
        goalkeeper.x = 240;
        goalkeeper.targetX = 240;
      }
    </script>
  </body>
</html>
