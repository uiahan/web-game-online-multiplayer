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
    <title>Ular Tangga Aesthetic</title>
    <style>
      :root {
        --bg-color: #f0f4f8;
        --primary-color: #6c5ce7;
        --secondary-color: #a29bfe;
        --p1-color: #ff7675;
        --p2-color: #74b9ff;
        --board-light: #f9f9f9;
        --board-dark: #dfe6e9;
      }

      * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      }

      body {
        background-color: var(--bg-color);
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 20px;
        color: #2d3436;
      }

      .container {
        display: flex;
        background: white;
        padding: 24px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        gap: 30px;
        max-width: 1000px;
        width: 100%;
        align-items: center;
      }

      /* Papan Game */
      .board-container {
        position: relative;
      }

      #board {
        display: grid;
        grid-template-columns: repeat(10, 55px);
        grid-template-rows: repeat(10, 55px);
        border: 4px solid #2d3436;
        border-radius: 8px;
        overflow: hidden;
        background: white;
      }

      .cell {
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: 600;
        font-size: 14px;
        position: relative;
        color: #636e72;
      }

      /* Efek Ular dan Tangga Sederhana di UI */
      .cell.snake-head::after {
        content: "🐍";
        position: absolute;
        top: 2px;
        right: 2px;
        font-size: 12px;
      }

      .cell.ladder-bottom::after {
        content: "🪜";
        position: absolute;
        bottom: 2px;
        right: 2px;
        font-size: 12px;
      }

      /* Bidak Pemain */
      .player-token {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        position: absolute;
        border: 2px solid white;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        transition: all 0.4s ease-in-out;
        z-index: 10;
      }

      .player-token.p1 {
        background-color: var(--p1-color);
      }
      .player-token.p2 {
        background-color: var(--p2-color);
      }

      /* Panel Kontrol */
      .controls {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 20px;
      }

      h1 {
        font-size: 28px;
        color: var(--primary-color);
        margin-bottom: 10px;
        text-align: center;
      }

      .turn-indicator {
        font-size: 18px;
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 30px;
        background: #f1f2f6;
        transition: all 0.3s ease;
        width: 100%;
        text-align: center;
      }

      .turn-p1 {
        background-color: #ffeaa7;
        color: #d63031;
      }
      .turn-p2 {
        background-color: #dff9fb;
        color: #0984e3;
      }

      /* Desain Dadu */
      .dice-area {
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .dice {
        width: 60px;
        height: 60px;
        background: white;
        border: 3px solid #2d3436;
        border-radius: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 28px;
        font-weight: bold;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease;
      }

      .dice.rolling {
        animation: roll 0.3s infinite linear;
      }

      @keyframes roll {
        0% {
          transform: rotate(0deg);
        }
        100% {
          transform: rotate(360deg);
        }
      }

      button {
        background-color: var(--primary-color);
        color: white;
        border: none;
        padding: 12px 30px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 8px;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(108, 92, 231, 0.3);
        transition: all 0.2s ease;
        width: 100%;
      }

      button:hover {
        background-color: #5b4cc4;
        transform: translateY(-2px);
      }

      button:disabled {
        background-color: #b2bec3;
        cursor: not-allowed;
        box-shadow: none;
        transform: none;
      }

      .log {
        width: 100%;
        height: 120px;
        background: #f8f9fa;
        border-radius: 8px;
        padding: 10px;
        font-size: 13px;
        overflow-y: auto;
        border: 1px solid #e9ecef;
      }

      .log-entry {
        margin-bottom: 5px;
        line-height: 1.4;
      }

      /* Responsif untuk Layar Kecil */
      @media (max-width: 850px) {
        .container {
          flex-direction: column;
          align-items: center;
        }
        #board {
          grid-template-columns: repeat(10, 32px);
          grid-template-rows: repeat(10, 32px);
        }
        .cell {
          font-size: 10px;
        }
        .player-token {
          width: 12px;
          height: 12px;
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
    <div class="container">
      <div class="board-container">
        <div id="board"></div>
        <div id="p1-token" class="player-token p1"></div>
        <div id="p2-token" class="player-token p2"></div>
      </div>

      <div class="controls">
        <div>
          <h1>Ular Tangga</h1>
          <p style="text-align: center; color: #b2bec3; font-size: 14px">
            Edisi Minimalis & Aesthetic
          </p>
        </div>

        <div id="turnIndicator" class="turn-indicator turn-p1">
          Giliran: Pemain 1 🔴
        </div>

        <div class="dice-area">
          <div id="dice" class="dice">1</div>
        </div>

        <button id="rollBtn" onclick="playTurn()">Kocok Dadu</button>
        <button
          id="resetBtn"
          onclick="resetGame()"
          style="background-color: #e17055; box-shadow: none; display: none"
        >
          Main Lagi
        </button>

        <div class="log" id="gameLog">
          <div class="log-entry" style="color: #636e72">
            Game dimulai! Pemain 1 silakan kocok dadu.
          </div>
        </div>
      </div>
    </div>

    <script>
      const board = document.getElementById("board");
      const gameLog = document.getElementById("gameLog");
      const rollBtn = document.getElementById("rollBtn");
      const resetBtn = document.getElementById("resetBtn");
      const diceDisplay = document.getElementById("dice");
      const turnIndicator = document.getElementById("turnIndicator");

      // Posisi awal pemain
      let playerPositions = { 1: 0, 2: 0 };
      let currentPlayer = 1;
      let isRolling = false;

      // Mapping Ular (Turun) & Tangga (Naik)
      const snakesAndLadders = {
        // Tangga (Kunci awal: Kunci akhir)
        3: 21,
        8: 30,
        28: 84,
        58: 77,
        75: 86,
        80: 100,
        // Ular
        17: 13,
        52: 29,
        57: 40,
        62: 22,
        88: 18,
        95: 51,
        97: 79,
      };

      // Render Papan 10x10 secara Boustrophedon (Zig-zag)
      function createBoard() {
        board.innerHTML = "";
        for (let row = 9; row >= 0; row--) {
          for (let col = 0; col < 10; col++) {
            let cellId;
            if (row % 2 === 1) {
              // Baris ganjil: kanan ke kiri
              cellId = row * 10 + (10 - col);
            } else {
              // Baris genap: kiri ke kanan
              cellId = row * 10 + (col + 1);
            }

            const cell = document.createElement("div");
            cell.className = "cell";
            cell.id = `cell-${cellId}`;
            cell.innerText = cellId;

            // Pewarnaan kotak selang-seling aesthetic
            if ((row + col) % 2 === 0) {
              cell.style.backgroundColor = "var(--board-light)";
            } else {
              cell.style.backgroundColor = "var(--board-dark)";
            }

            // Beri penanda visual sederhana untuk ular/tangga
            if (snakesAndLadders[cellId]) {
              if (snakesAndLadders[cellId] > cellId) {
                cell.classList.add("ladder-bottom");
                cell.style.color = "#2ecc71";
              } else {
                cell.classList.add("snake-head");
                cell.style.color = "#e74c3c";
              }
            }

            board.appendChild(cell);
          }
        }
      }

      // Update posisi grafis bidak di layar
      function updateTokenPositions() {
        [1, 2].forEach((player) => {
          const pos = playerPositions[player];
          const token = document.getElementById(`p${player}-token`);

          if (pos === 0) {
            // Posisi tunggu sebelum masuk papan
            if (player === 1) {
              token.style.left = "-35px";
              token.style.top = "45%";
            } else {
              token.style.left = "-35px";
              token.style.top = "55%";
            }
          } else {
            const cell = document.getElementById(`cell-${pos}`);
            if (cell) {
              const rect = cell.getBoundingClientRect();
              const boardRect = board.getBoundingClientRect();

              // Hitung koordinat relatif terhadap papan game
              let offsetLeft = cell.offsetLeft + cell.offsetWidth / 2 - 10;
              let offsetTop = cell.offsetTop + cell.offsetHeight / 2 - 10;

              // Menggeser sedikit bidak player 2 agar tidak menumpuk sempurna
              if (player === 2) {
                offsetLeft += 5;
                offsetTop += 5;
              }

              token.style.left = `${offsetLeft}px`;
              token.style.top = `${offsetTop}px`;
            }
          }
        });
      }

      // Fungsi Log Aktivitas permainan
      function addLog(text, color = "#2d3436") {
        const entry = document.createElement("div");
        entry.className = "log-entry";
        entry.style.color = color;
        entry.innerText = text;
        gameLog.appendChild(entry);
        gameLog.scrollTop = gameLog.scrollHeight;
      }

      // Logika kocok dadu dan pergerakan
      function playTurn() {
        if (isRolling) return;
        isRolling = true;
        rollBtn.disabled = true;

        diceDisplay.classList.add("rolling");

        let rollCounter = 0;
        let fakeRollInterval = setInterval(() => {
          diceDisplay.innerText = Math.floor(Math.random() * 6) + 1;
          rollCounter++;
          if (rollCounter > 5) {
            clearInterval(fakeRollInterval);

            // Angka dadu asli
            const diceValue = Math.floor(Math.random() * 6) + 1;
            diceDisplay.innerText = diceValue;
            diceDisplay.classList.remove("rolling");

            processMove(diceValue);
          }
        }, 80);
      }

      function processMove(diceValue) {
        let currentPos = playerPositions[currentPlayer];
        let targetPos = currentPos + diceValue;
        const playerText = `Pemain ${currentPlayer}`;
        const pColor =
          currentPlayer === 1 ? "var(--p1-color)" : "var(--p2-color)";

        addLog(
          `${playerText} mengocok dadu dan mendapatkan angka ${diceValue}.`,
          pColor,
        );

        if (targetPos > 100) {
          addLog(
            `${playerText} membutuhkan angka pas untuk mencapai 100. Langkah dilewati.`,
            "#636e72",
          );
          switchTurn();
        } else {
          playerPositions[currentPlayer] = targetPos;
          updateTokenPositions();

          // Cek apakah ada Ular atau Tangga di target posisi baru
          setTimeout(() => {
            if (snakesAndLadders[targetPos]) {
              let finalPos = snakesAndLadders[targetPos];
              if (finalPos > targetPos) {
                addLog(
                  `Hebat! 🎉 ${playerText} naik tangga dari ${targetPos} ke ${finalPos}!`,
                  "#2ecc71",
                );
              } else {
                addLog(
                  `Oh tidak! 🐍 ${playerText} digigit ular dari ${targetPos} turun ke ${finalPos}!`,
                  "#e74c3c",
                );
              }
              playerPositions[currentPlayer] = finalPos;
              updateTokenPositions();
            }

            // Cek kondisi menang
            if (playerPositions[currentPlayer] === 100) {
              addLog(
                `🏆 SELAMAT! ${playerText} memenangkan permainan!`,
                "#6c5ce7",
              );
              turnIndicator.innerText = `${playerText} MENANG! 👑`;
              turnIndicator.className = "turn-indicator";
              turnIndicator.style.backgroundColor = "#6c5ce7";
              turnIndicator.style.color = "white";
              rollBtn.style.display = "none";
              resetBtn.style.display = "block";
            } else {
              switchTurn();
            }
          }, 500); // delay jeda visual gerakan dadu/ular
        }
      }

      function switchTurn() {
        currentPlayer = currentPlayer === 1 ? 2 : 1;
        if (currentPlayer === 1) {
          turnIndicator.innerText = "Giliran: Pemain 1 🔴";
          turnIndicator.className = "turn-indicator turn-p1";
        } else {
          turnIndicator.innerText = "Giliran: Pemain 2 🔵";
          turnIndicator.className = "turn-indicator turn-p2";
        }
        isRolling = false;
        rollBtn.disabled = false;
      }

      function resetGame() {
        playerPositions = { 1: 0, 2: 0 };
        currentPlayer = 1;
        isRolling = false;
        diceDisplay.innerText = "1";
        gameLog.innerHTML =
          '<div class="log-entry" style="color: #636e72;">Game di-reset! Pemain 1 silakan kocok dadu.</div>';

        turnIndicator.innerText = "Giliran: Pemain 1 🔴";
        turnIndicator.className = "turn-indicator turn-p1";
        turnIndicator.style.backgroundColor = "";
        turnIndicator.style.color = "";

        rollBtn.style.display = "block";
        rollBtn.disabled = false;
        resetBtn.style.display = "none";

        updateTokenPositions();
      }

      // Inisialisasi awal saat halaman dibuka
      createBoard();
      updateTokenPositions();
    </script>
  </body>
</html>
