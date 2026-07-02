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
    <title>Ulet Keket</title>
    <style>
      /* --- RESET & BASIC STYLES --- */
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Segoe UI", Roboto, sans-serif;
        user-select: none;
      }

      body {
        background: #0d0e15;
        color: #fff;
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        position: relative;
      }

      /* --- UI HUB / CONTAINER GAME --- */
      #game-container {
        position: relative;
        width: 100vw;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
      }

      /* Canvas Arena */
      canvas {
        background: #090a0f;
        box-shadow: 0 0 30px rgba(0, 0, 0, 0.8);
        cursor: crosshair;
      }

      /* --- DASHBOARD UI (AESTHETIC OVERLAY) --- */
      .ui-overlay {
        position: absolute;
        pointer-events: none;
        z-index: 10;
      }

      #score-board {
        top: 20px;
        left: 20px;
        background: rgba(255, 255, 255, 0.07);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 15px 25px;
        border-radius: 16px;
        font-size: 1.1rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
      }

      #score-board span {
        color: #00f2fe;
        text-shadow: 0 0 8px rgba(0, 242, 254, 0.6);
      }

      /* --- MENU START & GAME OVER SCREEN --- */
      .screen-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(13, 14, 21, 0.85);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        z-index: 20;
        transition: opacity 0.3s ease;
      }

      .menu-box {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.08);
        padding: 40px 50px;
        border-radius: 28px;
        text-align: center;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        max-width: 400px;
        width: 90%;
      }

      h1 {
        font-size: 2.2rem;
        background: linear-gradient(45deg, #00f2fe, #4facfe);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 10px;
        font-weight: 800;
      }

      .rules {
        font-size: 0.9rem;
        color: #a0a5c0;
        line-height: 1.6;
        margin-bottom: 30px;
      }

      .btn-action {
        padding: 14px 35px;
        font-size: 1rem;
        font-weight: 700;
        color: #fff;
        background: linear-gradient(135deg, #00f2fe 0%, #4facfe 100%);
        border: none;
        border-radius: 14px;
        cursor: pointer;
        pointer-events: auto;
        transition: all 0.25s ease;
        box-shadow: 0 5px 15px rgba(0, 242, 254, 0.3);
      }

      .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 242, 254, 0.5);
      }

      /* Menyembunyikan elemen secara elegan */
      .hidden {
        opacity: 0;
        pointer-events: none;
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
    <div id="game-container">
      <div id="score-board" class="ui-overlay">
        Panjang Cacing: <span id="score-val">10</span>
      </div>

      <canvas id="gameCanvas"></canvas>

      <div id="start-screen" class="screen-overlay">
        <div class="menu-box">
          <h1>Ulet Keket</h1>
          <p class="rules">
            Gerakkan kursor atau sentuh layar untuk mengarahkan cacing. Makan
            partikel cahaya sebanyak-banyaknya dan jangan biarkan kepala
            menabrak batas dinding luar arena! ✨
          </p>
          <button class="btn-action" onclick="startGame()">
            Mulai Main 🚀
          </button>
        </div>
      </div>

      <div id="gameover-screen" class="screen-overlay hidden">
        <div class="menu-box">
          <h1
            style="
              background: linear-gradient(45deg, #ff416c, #ff4b2b);
              -webkit-background-clip: text;
              -webkit-text-fill-color: transparent;
            "
          >
            Game Over! 👻
          </h1>
          <p class="rules" id="final-score-text">
            Kamu mengeliminasi cacing sendiri dengan menabrak dinding pelindung.
          </p>
          <button
            class="btn-action"
            style="
              background: linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%);
              box-shadow: 0 5px 15px rgba(255, 65, 108, 0.3);
            "
            onclick="restartGame()"
          >
            Coba Lagi 🔄
          </button>
        </div>
      </div>
    </div>

    <script>
      const canvas = document.getElementById("gameCanvas");
      const ctx = canvas.getContext("2d");

      // Pengaturan Skala Resolusi Canvas Sesuai Viewport Layar
      let width = window.innerWidth;
      let height = window.innerHeight;
      canvas.width = width;
      canvas.height = height;

      // Dimensi Peta Arena Dunia Virtual (Lebih luas dari layar asli)
      const ARENA_WIDTH = 2500;
      const ARENA_HEIGHT = 2500;

      // State Struktur Data Game
      let worm = [];
      let foods = [];
      let score = 10;
      let isPlaying = false;

      // Vektor Posisi Target Kamera / Input Kendali
      let mouse = { x: width / 2, y: height / 2 };
      let camera = { x: 0, y: 0 };

      // Properti Fisika Gerak Cacing
      const segmentRadius = 12;
      const speed = 4;

      // Event Listener Responsif Perangkat
      window.addEventListener("resize", () => {
        width = window.innerWidth;
        height = window.innerHeight;
        canvas.width = width;
        canvas.height = height;
      });

      // Deteksi Kursor Mouse & Sentuhan Mobile Screen
      window.addEventListener("mousemove", (e) => {
        updateMousePos(e.clientX, e.clientY);
      });
      window.addEventListener("touchmove", (e) => {
        if (e.touches.length > 0) {
          updateMousePos(e.touches[0].clientX, e.touches[0].clientY);
        }
      });

      function updateMousePos(clientX, clientY) {
        mouse.x = clientX;
        mouse.y = clientY;
      }

      // --- SISTEM ATURAN MAIN GAME ---
      function startGame() {
        document.getElementById("start-screen").classList.add("hidden");
        initGameData();
      }

      function restartGame() {
        document.getElementById("gameover-screen").classList.add("hidden");
        initGameData();
      }

      function initGameData() {
        score = 10;
        document.getElementById("score-val").innerText = score;

        // Spawn Cacing di Titik Tengah Peta Dunia
        worm = [];
        let startX = ARENA_WIDTH / 2;
        let startY = ARENA_HEIGHT / 2;
        for (let i = 0; i < score; i++) {
          worm.push({ x: startX, y: startY + i * 8 });
        }

        // Spawn Makanan Neon Secara Acak di Seluruh Penjuru Peta
        foods = [];
        for (let i = 0; i < 150; i++) {
          spawnFood();
        }

        isPlaying = true;
        animate();
      }

      function spawnFood() {
        const colors = [
          "#00f2fe",
          "#4facfe",
          "#ff416c",
          "#00b894",
          "#f1c40f",
          "#e84393",
          "#9b59b6",
        ];
        foods.push({
          x: Math.random() * (ARENA_WIDTH - 40) + 20,
          y: Math.random() * (ARENA_HEIGHT - 40) + 20,
          radius: Math.random() * 4 + 3,
          color: colors[Math.floor(Math.random() * colors.length)],
        });
      }

      // --- CORE GAME LOOP (REDUCE LATENCY & BUG FREE) ---
      function animate() {
        if (!isPlaying) return;

        updatePhysics();
        drawFrame();

        requestAnimationFrame(animate);
      }

      function updatePhysics() {
        let head = worm[0];

        // Translasi Posisi Input Layar ke Koordinat Dunia Nyata Virtual
        let targetX = head.x + (mouse.x - width / 2);
        let targetY = head.y + (mouse.y - height / 2);

        // Hitung Sudut Trigonometri untuk Pergerakan Rotasi Mulus
        let dx = targetX - head.x;
        let dy = targetY - head.y;
        let angle = Math.atan2(dy, dx);

        // Simpan riwayat koordinat kepala sebelum bergerak meluncur
        let prevX = head.x;
        let prevY = head.y;

        // Update posisi kepala cacing berdasarkan fungsi trigonometri arah kecepatan
        head.x += Math.cos(angle) * speed;
        head.y += Math.sin(angle) * speed;

        // Validasi Tabrakan dengan Dinding Batas Arena Luar (Boundary Collision Check)
        if (
          head.x < 0 ||
          head.x > ARENA_WIDTH ||
          head.y < 0 ||
          head.y > ARENA_HEIGHT
        ) {
          triggerGameOver();
          return;
        }

        // Update Bagian Ekor/Tubuh Mengikuti Segmen di Depannya Secara Elastis
        for (let i = 1; i < worm.length; i++) {
          let seg = worm[i];
          let sDx = worm[i - 1].x - seg.x;
          let sDy = worm[i - 1].y - seg.y;
          let sDist = Math.sqrt(sDx * sDx + sDy * sDy);

          // Jarak ikat konstan antar segmen tubuh agar tidak molor/terputus
          const targetDist = 7;
          if (sDist > targetDist) {
            let ratio = targetDist / sDist;
            seg.x = worm[i - 1].x - sDx * ratio;
            seg.y = worm[i - 1].y - sDy * ratio;
          }
        }

        // Deteksi Memakan Makanan Kognitif (Circle-to-Circle Collision Check)
        for (let i = foods.length - 1; i >= 0; i--) {
          let f = foods[i];
          let fDx = head.x - f.x;
          let fDy = head.y - f.y;
          let dist = Math.sqrt(fDx * fDx + fDy * fDy);

          if (dist < segmentRadius + f.radius) {
            foods.splice(i, 1);
            growWorm();
            spawnFood(); // Selalu jaga populasi jumlah makanan konstan
          }
        }

        // Set Fokus Kamera Mengunci Kepala Cacing Stabil di Pusat Layar Monitor
        camera.x = head.x - width / 2;
        camera.y = head.y - height / 2;
      }

      function growWorm() {
        score++;
        document.getElementById("score-val").innerText = score;

        // Tambahkan segmen ekor baru tepat di posisi ujung ekor saat ini
        let lastSegment = worm[worm.length - 1];
        worm.push({ x: lastSegment.x, y: lastSegment.y });
      }

      function triggerGameOver() {
        isPlaying = false;
        document.getElementById("final-score-text").innerText =
          `Hebat! Cacing neon milikmu berhasil tumbuh hingga panjang ${score} meter sebelum menabrak pembatas arena.`;
        document.getElementById("gameover-screen").classList.remove("hidden");
      }

      // --- SISTEM RENDERING GRAFIS CANVAS (AESTHETIC NEON GLOW) ---
      function drawFrame() {
        // Clear Frame Lama
        ctx.clearRect(0, 0, width, height);

        ctx.save();
        // Lakukan Translasi Kamera Mengikuti Pergerakan Dinamis Kepala Cacing
        ctx.translate(-camera.x, -camera.y);

        // 1. Gambar Garis Kisi Lapisan Latar Belakang (Grid Background)
        ctx.strokeStyle = "#181a26";
        ctx.lineWidth = 1;
        const gridSize = 50;

        // Gambar Garis Vertikal Kisi
        for (let x = 0; x <= ARENA_WIDTH; x += gridSize) {
          ctx.beginPath();
          ctx.moveTo(x, 0);
          ctx.lineTo(x, ARENA_HEIGHT);
          ctx.stroke();
        }
        // Gambar Garis Horizontal Kisi
        for (let y = 0; y <= ARENA_HEIGHT; y += gridSize) {
          ctx.beginPath();
          ctx.moveTo(0, y);
          ctx.lineTo(ARENA_WIDTH, y);
          ctx.stroke();
        }

        // 2. Gambar Tembok Batas Luar Arena (Border Barrier)
        ctx.strokeStyle = "#ff416c";
        ctx.lineWidth = 6;
        ctx.shadowBlur = 15;
        ctx.shadowColor = "#ff416c";
        ctx.strokeRect(0, 0, ARENA_WIDTH, ARENA_HEIGHT);
        ctx.shadowBlur = 0; // Matikan shadow agar performa tidak drop untuk elemen kecil

        // 3. Gambar Seluruh Makanan Bercahaya (Glowing Feed)
        foods.forEach((f) => {
          ctx.beginPath();
          ctx.arc(f.x, f.y, f.radius, 0, Math.PI * 2);
          ctx.fillStyle = f.color;
          ctx.fill();
        });

        // 4. Gambar Tubuh Cacing (Worm Segment Mesh)
        // Gambar dari ekor ke kepala agar segmen kepala menindih badan dengan rapi
        for (let i = worm.length - 1; i >= 0; i--) {
          ctx.beginPath();
          ctx.arc(worm[i].x, worm[i].y, segmentRadius, 0, Math.PI * 2);

          if (i === 0) {
            // Gaya Visual Kepala Cacing (Neon Turqoise Utama)
            ctx.fillStyle = "#00f2fe";
            ctx.shadowBlur = 12;
            ctx.shadowColor = "#00f2fe";
            ctx.fill();
            ctx.shadowBlur = 0;

            // Gambar Sepasang Mata Indah Berpijar
            ctx.fillStyle = "#fff";
            ctx.beginPath();
            ctx.arc(worm[i].x - 4, worm[i].y - 4, 3, 0, Math.PI * 2);
            ctx.arc(worm[i].x + 4, worm[i].y - 4, 3, 0, Math.PI * 2);
            ctx.fill();
          } else {
            // Efek Gradasi Warna Ekor Menggunakan Pola Alami Interaktif
            ctx.fillStyle = `hsl(${(200 + i * 2) % 360}, 85%, 60%)`;
            ctx.fill();
          }
        }

        ctx.restore();
      }
    </script>
  </body>
</html>
