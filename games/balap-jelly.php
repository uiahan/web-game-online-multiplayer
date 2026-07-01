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
    <title>Cozy Jelly Drift! 🏎️🍮</title>
    <style>
      /* --- TEMA UI RETRO PASTEL ESTETIK --- */
      :root {
        --bg-cozy: #f0f4f8; /* Abu-abu terang super soft */
        --panel-white: #ffffff; /* Putih bersih minimalis */
        --jelly-pink: #ff8fa3; /* Pink cerah pastel khas jelly */
        --soft-blue: #a0c4ff; /* Biru pastel lembut untuk rival */
        --soft-gold: #ffd6a5; /* Emas pastel hangat untuk skor */
        --asphalt-gray: #4a5568; /* Aspal abu-abu hangat */
        --grass-green: #c1e1c1; /* Hijau pastel adem untuk pinggiran */
        --text-dark: #2d3748;
      }

      body {
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        background-color: var(--bg-cozy);
        color: var(--text-dark);
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
      }

      header h1 {
        font-size: 2rem;
        margin: 0;
        color: #ff758f;
        letter-spacing: 1px;
      }

      header p {
        margin: 5px 0 0 0;
        color: #718096;
        font-size: 0.9rem;
      }

      /* AREA PANEL GAME UTAMA */
      #game-wrapper {
        position: relative;
        box-shadow: 0 15px 35px rgba(113, 128, 150, 0.2);
        border-radius: 24px;
        overflow: hidden;
        border: 4px solid var(--panel-white);
      }

      /* Papan Informasi Atas Minimalis */
      .hud-bar {
        background-color: var(--panel-white);
        padding: 14px 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: bold;
        border-bottom: 2px solid #e2e8f0;
      }

      .hud-item {
        font-size: 1rem;
        color: var(--text-dark);
      }

      .hud-item span {
        color: #495057;
        background-color: #edf2f7;
        padding: 4px 10px;
        border-radius: 12px;
        margin-left: 4px;
      }

      #score-val {
        background-color: #fef3c7 !important;
        color: #b45309 !important;
      }

      canvas {
        background-color: var(--asphalt-gray);
        display: block;
      }

      /* POP-UP GAME OVER PASTELL */
      #game-over-overlay {
        display: none;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(45, 55, 72, 0.7);
        backdrop-filter: blur(4px);
        z-index: 10;
        align-items: center;
        justify-content: center;
        flex-direction: column;
      }

      #game-over-box {
        background-color: var(--panel-white);
        padding: 35px 45px;
        border-radius: 24px;
        text-align: center;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        transform: scale(0.9);
        animation: popIn 0.3s forwards cubic-bezier(0.175, 0.885, 0.32, 1.275);
        max-width: 80%;
      }

      @keyframes popIn {
        to {
          transform: scale(1);
        }
      }

      #game-over-box h2 {
        font-size: 2rem;
        color: #e53e3e;
        margin-top: 0;
        margin-bottom: 10px;
      }

      #game-over-box p {
        color: #4a5568;
        font-size: 1rem;
        margin-bottom: 20px;
      }

      .restart-btn {
        padding: 12px 32px;
        font-size: 1rem;
        font-weight: bold;
        background: linear-gradient(135deg, #ff758f 0%, #ff8fa3 100%);
        color: white;
        border: none;
        border-radius: 20px;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(255, 117, 143, 0.3);
        transition:
          transform 0.1s,
          filter 0.2s;
      }

      .restart-btn:hover {
        transform: scale(1.03);
        filter: brightness(1.05);
      }

      .restart-btn:active {
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
      <h1>JELLY DRIFT COZY</h1>
      <p>
        Gunakan tombol arah KANAN / KIRI / ATAS / BAWAH ( ◀ ▶ ▲ ▼ ) untuk
        mengendalikan mobil!
      </p>
    </header>

    <div id="game-wrapper">
      <div class="hud-bar">
        <div class="hud-item">Jarak: <span id="distance-val">0</span>m</div>
        <div class="hud-item">Skor: <span id="score-val">0</span></div>
        <div class="hud-item">Posisi: <span id="pos-val">4</span>/4</div>
      </div>

      <canvas id="raceCanvas" width="460" height="580"></canvas>

      <div id="game-over-overlay">
        <div id="game-over-box">
          <h2>Ouch! 💥</h2>
          <p>Mobil Jelly kamu bertubrukan di lintasan santai!</p>
          <div
            style="
              font-size: 1.2rem;
              font-weight: bold;
              margin-bottom: 25px;
              color: var(--text-dark);
            "
          >
            Skor Akhir:
            <span
              style="
                color: #b45309;
                background-color: #fef3c7;
                padding: 2px 8px;
                border-radius: 8px;
              "
              id="final-score"
              >0</span
            >
          </div>
          <button class="restart-btn" onclick="resetRace()">MAIN LAGI</button>
        </div>
      </div>
    </div>

    <script>
      const canvas = document.getElementById("raceCanvas");
      const ctx = canvas.getContext("2d");
      const gameOverOverlay = document.getElementById("game-over-overlay");
      const scoreDisplay = document.getElementById("score-val");
      const distanceDisplay = document.getElementById("distance-val");
      const positionDisplay = document.getElementById("pos-val");
      const finalScoreDisplay = document.getElementById("final-score");

      // Game States
      let score = 0;
      let distance = 0;
      let gameActive = true;
      let globalSpeed = 5.5;
      let roadOffset = 0;

      // Lajur Lintasan Jalan (Dipaskan simetris di dalam jalan)
      const lanesX = [75, 165, 255, 345];

      // Spesifikasi Mobil Pemain (Mobil Jelly Pink Pastel)
      const player = {
        x: 210,
        y: 450,
        width: 46,
        height: 70,
        speed: 6.2,
        jellyWobble: 0,
      };

      // Array Penampung Mobil Musuh
      let rivalCars = [];

      // Input Keyboard System
      const keys = {
        ArrowLeft: false,
        ArrowRight: false,
        ArrowUp: false,
        ArrowDown: false,
      };
      window.addEventListener("keydown", (e) => {
        if (e.key in keys) keys[e.key] = true;
      });
      window.addEventListener("keyup", (e) => {
        if (e.key in keys) keys[e.key] = false;
      });

      // Fungsi Memasukkan Mobil Rival Baru
      function spawnRivalCar() {
        if (!gameActive) return;

        const randomLaneIdx = Math.floor(Math.random() * lanesX.length);
        const targetX = lanesX[randomLaneIdx];

        const overlapping = rivalCars.some(
          (car) => car.y < 130 && car.laneIdx === randomLaneIdx,
        );
        if (overlapping) {
          setTimeout(spawnRivalCar, 200);
          return;
        }

        // Warna-warna pastel kalem untuk mobil bot
        const rivalColors = [
          "#a0c4ff",
          "#bdb2ff",
          "#ffc6ff",
          "#ffd166",
          "#9bc5c3",
        ];
        const randomColor =
          rivalColors[Math.floor(Math.random() * rivalColors.length)];

        rivalCars.push({
          x: targetX,
          y: -90,
          width: 46,
          height: 70,
          speed: Math.random() * 1.8 + 1,
          color: randomColor,
          laneIdx: randomLaneIdx,
        });

        const nextSpawnTime = Math.random() * (1500 - 900) + 900 - score * 0.4;
        setTimeout(spawnRivalCar, Math.max(nextSpawnTime, 500));
      }

      // Loop Animasi & Logika Utama
      function updateRaceEngine() {
        if (!gameActive) return;

        ctx.clearRect(0, 0, canvas.width, canvas.height);

        // Gerakan Marka Jalan Berputar
        roadOffset += globalSpeed + score * 0.02;
        if (roadOffset > 60) roadOffset = 0;

        // 1. Bahu Samping Kiri-Kanan Lintasan (Hijau Rumput Pastel)
        ctx.fillStyle = "#c1e1c1";
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        // 2. Badan Jalan Utama (Abu-Abu Hangat)
        ctx.fillStyle = "#4a5568";
        ctx.fillRect(50, 0, canvas.width - 100, canvas.height);

        // Garis Pembatas Samping Jalan Putih Solid yang Halus
        ctx.fillStyle = "#ffffff";
        ctx.fillRect(48, 0, 3, canvas.height);
        ctx.fillRect(canvas.width - 51, 0, 3, canvas.height);

        // Marka Putus-Putus Tengah Jalan (Warna putih pudar kalem)
        ctx.strokeStyle = "rgba(255, 255, 255, 0.25)";
        ctx.lineWidth = 3;
        ctx.setLineDash([25, 25]);
        ctx.lineDashOffset = -roadOffset;

        ctx.beginPath();
        ctx.moveTo(142, 0);
        ctx.lineTo(142, canvas.height);
        ctx.moveTo(230, 0);
        ctx.lineTo(230, canvas.height);
        ctx.moveTo(318, 0);
        ctx.lineTo(318, canvas.height);
        ctx.stroke();
        ctx.setLineDash([]); // Matikan line dash agar tidak merusak elemen gambar lain

        // 3. Kontrol Pergerakan Mobil Jelly Player
        if (keys.ArrowLeft && player.x > 55) {
          player.x -= player.speed;
          player.jellyWobble = -5;
        } else if (
          keys.ArrowRight &&
          player.x < canvas.width - 55 - player.width
        ) {
          player.x += player.speed;
          player.jellyWobble = 5;
        } else {
          player.jellyWobble = Math.sin(Date.now() / 100) * 1.8; // Goyangan jelly lembut lurus
        }

        if (keys.ArrowUp && player.y > 60) player.y -= player.speed * 0.65;
        if (keys.ArrowDown && player.y < canvas.height - player.height - 20)
          player.y += player.speed * 0.65;

        // 4. Menggambar Mobil Balap Jelly Pemain (Aman tanpa roundRect)
        ctx.save();
        ctx.translate(
          player.x + player.width / 2,
          player.y + player.height / 2,
        );

        // Body Mobil Pink Pastel
        ctx.fillStyle = "#ff8fa3";
        ctx.fillRect(
          -player.width / 2 + player.jellyWobble,
          -player.height / 2,
          player.width,
          player.height,
        );

        // Kaca Depan Mobil Pemain (Putih minimalis)
        ctx.fillStyle = "#ffffff";
        ctx.fillRect(-13 + player.jellyWobble, -22, 26, 14);

        // Spoiler Belakang Mobil Pemain (Warna pink lebih gelap)
        ctx.fillStyle = "#ff4d6d";
        ctx.fillRect(-20 + player.jellyWobble, 24, 40, 6);
        ctx.restore();

        // 5. Kelola Pergerakan & Render Mobil Balap Bot Musuh
        let activeRank = 4;

        for (let i = rivalCars.length - 1; i >= 0; i--) {
          let rival = rivalCars[i];
          rival.y += globalSpeed + score * 0.02 - rival.speed;

          if (player.y < rival.y) {
            activeRank--;
          }

          // Gambar Mobil Balap Rival Kalem
          ctx.fillStyle = rival.color;
          ctx.fillRect(rival.x, rival.y, rival.width, rival.height);

          // Kaca Depan Mobil Rival
          ctx.fillStyle = "#ffffff";
          ctx.fillRect(rival.x + 9, rival.y + 10, rival.width - 18, 14);

          // Lampu Belakang Oranye Lembut Mobil Rival
          ctx.fillStyle = "#fbcfe8";
          ctx.fillRect(rival.x + 5, rival.y + rival.height - 5, 6, 3);
          ctx.fillRect(
            rival.x + rival.width - 11,
            rival.y + rival.height - 5,
            6,
            3,
          );

          // Deteksi Tabrakan Aman Tanpa Bug
          if (
            player.x < rival.x + rival.width - 3 &&
            player.x + player.width > rival.x + 3 &&
            player.y < rival.y + rival.height - 3 &&
            player.y + player.height > rival.y + 3
          ) {
            triggerCrash();
          }

          if (rival.y > canvas.height) {
            rivalCars.splice(i, 1);
            score += 25; // Skor menyalip
          }
        }

        // 6. Update Info HUD Papan Skor Minimalis
        distance += Math.floor(globalSpeed / 3.5);
        distanceDisplay.textContent = distance;
        scoreDisplay.textContent = score + Math.floor(distance / 10);
        positionDisplay.textContent = Math.max(activeRank, 1);

        requestAnimationFrame(updateRaceEngine);
      }

      function triggerCrash() {
        gameActive = false;
        finalScoreDisplay.textContent = score + Math.floor(distance / 10);
        gameOverOverlay.style.display = "flex";
      }

      function resetRace() {
        score = 0;
        distance = 0;
        rivalCars = [];
        player.x = 210;
        player.y = 450;
        gameActive = true;
        gameOverOverlay.style.display = "none";
        updateRaceEngine();
      }

      // Jalankan game
      setTimeout(spawnRivalCar, 1000);
      updateRaceEngine();
    </script>
  </body>
</html>
