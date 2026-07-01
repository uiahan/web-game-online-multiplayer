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
    <title>Slide Puzzle</title>
    <style>
      /* --- RESET & CORE STYLES --- */
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        user-select: none;
      }

      body {
        background: linear-gradient(135deg, #e0c3fc 0%, #8ec5fc 100%);
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        position: relative;
      }

      /* --- CONTAINER UTAMA --- */
      .game-wrapper {
        background: rgba(255, 255, 255, 0.45);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border: 1px solid rgba(255, 255, 255, 0.6);
        border-radius: 24px;
        padding: 30px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        text-align: center;
        max-width: 440px;
        width: 90%;
        z-index: 10;
      }

      h1 {
        color: #4a4e69;
        font-size: 1.8rem;
        margin-bottom: 5px;
        font-weight: 700;
        letter-spacing: -0.5px;
      }

      p.subtitle {
        color: #6c5ce7;
        font-size: 0.9rem;
        margin-bottom: 20px;
        font-weight: 500;
      }

      /* --- STATS BAR --- */
      .stats-bar {
        display: flex;
        justify-content: space-between;
        background: rgba(255, 255, 255, 0.6);
        padding: 10px 20px;
        border-radius: 14px;
        margin-bottom: 20px;
        font-size: 0.95rem;
        color: #4a4e69;
        font-weight: 600;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.02);
      }

      .stats-bar span span {
        color: #6c5ce7;
        font-weight: 700;
      }

      /* --- BOARD PUZZLE --- */
      .puzzle-board {
        width: 100%;
        aspect-ratio: 1 / 1;
        background: rgba(255, 255, 255, 0.5);
        border: 4px solid white;
        border-radius: 16px;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        grid-template-rows: repeat(3, 1fr);
        gap: 6px;
        padding: 6px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.04);
        margin-bottom: 25px;
      }

      /* --- KOTAK / TILE PUZZLE --- */
      .tile {
        background: linear-gradient(135deg, #a29bfe 0%, #6c5ce7 100%);
        color: white;
        font-size: 1.8rem;
        font-weight: 700;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 10px;
        cursor: pointer;
        box-shadow: 0 4px 10px rgba(108, 92, 231, 0.2);
        transition:
          transform 0.15s ease,
          background 0.2s ease,
          box-shadow 0.15s ease;
      }

      .tile:hover:not(.empty) {
        transform: scale(1.02);
        box-shadow: 0 6px 14px rgba(108, 92, 231, 0.3);
      }

      .tile:active:not(.empty) {
        transform: scale(0.98);
      }

      /* Ubin Kosong */
      .tile.empty {
        background: transparent;
        box-shadow: none;
        cursor: default;
        pointer-events: none;
      }

      /* Ubin di Posisi Benar (Efek Glow Cantik) */
      .tile.correct {
        background: linear-gradient(135deg, #81ecec 0%, #00b894 100%);
        box-shadow: 0 4px 10px rgba(0, 184, 148, 0.2);
      }

      /* --- TOMBOL KONTROL --- */
      .btn-shuffle {
        background: white;
        color: #6c5ce7;
        border: 2px solid #a29bfe;
        padding: 12px 30px;
        font-size: 1rem;
        font-weight: 700;
        border-radius: 14px;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.02);
        width: 100%;
      }

      .btn-shuffle:hover {
        background: #6c5ce7;
        color: white;
        box-shadow: 0 6px 15px rgba(108, 92, 231, 0.3);
        transform: translateY(-1px);
      }

      /* --- POPUP CELEBRATION MODAL --- */
      .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 0;
        pointer-events: none;
        transition: all 0.3s ease;
        z-index: 100;
      }

      .modal-overlay.active {
        opacity: 1;
        pointer-events: auto;
      }

      .modal-box {
        background: white;
        padding: 35px 30px;
        border-radius: 24px;
        text-align: center;
        max-width: 380px;
        width: 85%;
        transform: scale(0.8);
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
      }

      .modal-overlay.active .modal-box {
        transform: scale(1);
      }

      .modal-box h2 {
        color: #00b894;
        margin-bottom: 10px;
        font-size: 1.6rem;
      }

      .modal-box p {
        color: #555;
        font-size: 0.95rem;
        line-height: 1.5;
        margin-bottom: 24px;
      }

      .btn-close-modal {
        background: linear-gradient(135deg, #6c5ce7 0%, #a29bfe 100%);
        color: white;
        padding: 12px 35px;
        border: none;
        border-radius: 50px;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 5px 15px rgba(108, 92, 231, 0.3);
      }

      .btn-close-modal:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(108, 92, 231, 0.4);
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
    <div class="game-wrapper">
      <h1>Mystic Slide</h1>
      <p class="subtitle">Urutkan angka sampai menjadi sempurna ✨</p>

      <!-- Stats Bar -->
      <div class="stats-bar">
        <span>Langkah: <span id="move-counter">0</span></span>
        <span>Status: <span id="game-status">Bermain</span></span>
      </div>

      <!-- Puzzle Board -->
      <div class="puzzle-board" id="board">
        <!-- Diisi dinamis oleh JS -->
      </div>

      <!-- Action Button -->
      <button class="btn-shuffle" onclick="initGame()">Acak Ulang 🔄</button>
    </div>

    <!-- Modal Menang -->
    <div class="modal-overlay" id="win-modal">
      <div class="modal-box">
        <h2>Luar Biasa! 🎉👏</h2>
        <p id="win-message">
          Kamu berhasil menyelesaikan puzzle ini dengan sangat rapi dan
          sempurna!
        </p>
        <button class="btn-close-modal" onclick="closeModal()">
          Main Lagi
        </button>
      </div>
    </div>

    <script>
      // State data game
      let tilesArray = [1, 2, 3, 4, 5, 6, 7, 8, ""];
      const correctOrder = [1, 2, 3, 4, 5, 6, 7, 8, ""];
      let moves = 0;
      let isGameActive = true;

      window.addEventListener("DOMContentLoaded", () => {
        initGame();
      });

      // Fungsi inisialisasi / acak puzzle
      function initGame() {
        moves = 0;
        isGameActive = true;
        document.getElementById("move-counter").innerText = moves;
        document.getElementById("game-status").innerText = "Bermain";
        document.getElementById("game-status").style.color = "#6c5ce7";

        shuffleTiles();
        renderBoard();
      }

      // Fungsi mengacak ubin dengan jaminan "Solvable" (Bisa diselesaikan)
      function shuffleTiles() {
        do {
          // Fisher-Yates Shuffle
          for (let i = tilesArray.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [tilesArray[i], tilesArray[j]] = [tilesArray[j], tilesArray[i]];
          }
        } while (!isSolvable(tilesArray) || isAlreadySolved(tilesArray));
      }

      // Mengecek apakah susunan acak bisa diselesaikan secara matematis (Inversion Check)
      function isSolvable(arr) {
        let inversions = 0;
        let checkArray = arr.filter((t) => t !== "");
        for (let i = 0; i < checkArray.length; i++) {
          for (let j = i + 1; j < checkArray.length; j++) {
            if (checkArray[i] > checkArray[j]) inversions++;
          }
        }
        return inversions % 2 === 0;
      }

      // Memastikan ubin tidak langsung teratur saat diacak
      function isAlreadySolved(arr) {
        return arr.every((val, index) => val === correctOrder[index]);
      }

      // Merender ubin ke dalam Grid HTML Board
      function renderBoard() {
        const board = document.getElementById("board");
        board.innerHTML = "";

        tilesArray.forEach((tile, index) => {
          const tileDiv = document.createElement("div");
          tileDiv.className = "tile";

          if (tile === "") {
            tileDiv.classList.add("empty");
          } else {
            tileDiv.innerText = tile;
            // Beri warna hijau jika posisinya sudah benar secara estetik
            if (tile === correctOrder[index]) {
              tileDiv.classList.add("correct");
            }
          }

          // Klik Event untuk pergeseran ubin
          tileDiv.onclick = () => moveTile(index);
          board.appendChild(tileDiv);
        });
      }

      // Fungsi memindahkan ubin jika berdekatan dengan ruang kosong
      function moveTile(index) {
        if (!isGameActive) return;

        const emptyIndex = tilesArray.indexOf("");

        // Logika koordinat baris dan kolom grid 3x3
        const tileRow = Math.floor(index / 3);
        const tileCol = index % 3;
        const emptyRow = Math.floor(emptyIndex / 3);
        const emptyCol = emptyIndex % 3;

        // Cek jarak: Hanya bisa geser jika bersebelahan langsung (Atas, Bawah, Kiri, Kanan)
        const isAdjacent =
          Math.abs(tileRow - emptyRow) + Math.abs(tileCol - emptyCol) === 1;

        if (isAdjacent) {
          // Tukar posisi nilai ubin
          [tilesArray[index], tilesArray[emptyIndex]] = [
            tilesArray[emptyIndex],
            tilesArray[index],
          ];
          moves++;
          document.getElementById("move-counter").innerText = moves;

          renderBoard();
          checkWinCondition();
        }
      }

      // Fungsi mengecek apakah player memenangkan permainan
      function checkWinCondition() {
        const isWin = tilesArray.every(
          (val, index) => val === correctOrder[index],
        );

        if (isWin) {
          isGameActive = false;
          document.getElementById("game-status").innerText = "Selesai ✨";
          document.getElementById("game-status").style.color = "#00b894";

          // Tampilkan Modal Menang
          document.getElementById("win-message").innerText =
            `Hebat! Kamu menyusun puzzle ini dengan sempurna hanya dalam ${moves} langkah!`;
          document.getElementById("win-modal").classList.add("active");
        }
      }

      // Menutup Modal Popup
      function closeModal() {
        document.getElementById("win-modal").classList.remove("active");
        initGame();
      }
    </script>
  </body>
</html>
