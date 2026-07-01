<?php
session_start();

// Jika belum login, tendang ke halaman login
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TicTacToe Online</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,700&family=Manrope:wght@400;500;600;700;800&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="../css/tic-tac-toe.css" />
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
    <main class="app-shell">
      <div class="topbar">
        <div class="topbar-copy">
          <h1><span>TicTacToe Online</span></h1>
        </div>
        <div class="top-actions">
          <button id="shareWhatsAppBtn" class="action-btn" type="button">
            <span class="button-icon" aria-hidden="true">↗</span
            ><span>Share Link Room</span>
          </button>
          <p id="roomInfo" class="pill" title="Room: -">
            <span id="roomInfoText">Room: -</span>
          </p>
        </div>
      </div>

      <div class="status-strip" id="statusStrip">
        <span id="statusIcon" class="status-icon" aria-hidden="true">⌛</span>
        <span id="statusText">Loading...</span>
        <!-- <span id="roleInfo">Kamu: -</span> -->
      </div>

      <section class="board-shell state-waiting" id="statusCard">
        <div id="board" aria-label="TicTacToe board"></div>
      </section>
    </main>

    <div id="gameModal" class="game-modal" aria-hidden="true">
      <div
        class="game-modal-card"
        role="dialog"
        aria-modal="true"
        aria-labelledby="gameModalTitle"
      >
        <h2 id="gameModalTitle" class="game-modal-title">Game selesai</h2>
        <p id="gameModalText" class="game-modal-text">-</p>
        <!-- <div class="game-modal-actions">
          <button id="gameModalCloseBtn" class="action-btn"
            type="button">Tutup</button>
        </div> -->
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js"></script>
    <script src="../js/tic-tac-toe.js"></script>
  </body>
</html>
