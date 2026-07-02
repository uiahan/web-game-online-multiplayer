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
    <title>MindRiddle</title>
    <style>
      /* --- RESET & BASIC STYLES --- */
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        user-select: none;
      }

      body {
        background: linear-gradient(135deg, #f5efe6 0%, #e8d8c8 100%);
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
        overflow-x: hidden;
      }

      /* --- CONTAINER UTAMA --- */
      .game-card {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.8);
        border-radius: 28px;
        padding: 35px;
        width: 100%;
        max-width: 480px;
        box-shadow: 0 15px 35px rgba(139, 126, 116, 0.1);
        text-align: center;
        transition: all 0.3s ease;
        position: relative;
      }

      .header-title {
        font-size: 1.6rem;
        color: #4a3f35;
        font-weight: 700;
        margin-bottom: 5px;
        letter-spacing: -0.5px;
      }

      .subtitle {
        font-size: 0.85rem;
        color: #8b7e74;
        margin-bottom: 25px;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        font-weight: 600;
      }

      /* --- SCORE & PROGRESS BAR --- */
      .progress-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        font-size: 0.9rem;
        color: #655843;
        font-weight: 600;
      }

      .score-badge {
        background: #fff;
        padding: 6px 14px;
        border-radius: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.02);
        border: 1px solid rgba(232, 216, 200, 0.6);
      }

      /* --- KOTAK PERTANYAAN --- */
      .riddle-box {
        background: #ffffff;
        border-radius: 20px;
        padding: 30px 20px;
        margin-bottom: 25px;
        min-height: 120px;
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0 8px 20px rgba(139, 126, 116, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.9);
      }

      .riddle-text {
        font-size: 1.15rem;
        color: #4a3f35;
        line-height: 1.6;
        font-weight: 500;
      }

      /* --- INPUT JAWABAN --- */
      .input-wrapper {
        position: relative;
        margin-bottom: 20px;
      }

      .answer-input {
        width: 100%;
        padding: 16px 20px;
        font-size: 1rem;
        border: 2px solid #e8d8c8;
        background: #fff;
        border-radius: 16px;
        outline: none;
        color: #4a3f35;
        font-weight: 500;
        transition: all 0.25s ease;
        text-align: center;
      }

      .answer-input:focus {
        border-color: #b09b85;
        box-shadow: 0 5px 15px rgba(176, 155, 133, 0.15);
      }

      /* --- TOMBOL AKSI --- */
      .action-btn {
        width: 100%;
        padding: 16px;
        font-size: 1rem;
        font-weight: 700;
        color: white;
        background: #8b7e74;
        border: none;
        border-radius: 16px;
        cursor: pointer;
        transition: all 0.25s ease;
        box-shadow: 0 6px 15px rgba(139, 126, 116, 0.2);
        letter-spacing: 0.5px;
      }

      .action-btn:hover {
        background: #7a6e64;
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(139, 126, 116, 0.3);
      }

      .action-btn:active {
        transform: translateY(1px);
      }

      /* --- FEEDBACK MESSAGE --- */
      .feedback-message {
        margin-top: 15px;
        font-size: 0.95rem;
        font-weight: 600;
        min-height: 22px;
        transition: color 0.2s ease;
      }
      .feedback-message.correct {
        color: #557c55;
      }
      .feedback-message.wrong {
        color: #a94442;
      }

      /* --- SCREEN BERHASIL / TAMAT --- */
      .end-screen {
        display: none;
      }

      .end-screen h2 {
        color: #557c55;
        font-size: 1.8rem;
        margin-bottom: 15px;
      }

      .end-screen p {
        color: #655843;
        font-size: 1rem;
        line-height: 1.5;
        margin-bottom: 25px;
      }

      .btn-restart {
        background: #557c55;
        box-shadow: 0 6px 15px rgba(85, 124, 85, 0.2);
      }
      .btn-restart:hover {
        background: #466646;
        box-shadow: 0 8px 20px rgba(85, 124, 85, 0.3);
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
    <div class="game-card" id="game-card">
      <!-- SCREEN UTAMA GAME -->
      <div id="play-screen">
        <h1 class="header-title">MindRiddle</h1>
        <p class="subtitle">Asah Logika & Tebak Kata ✨</p>

        <div class="progress-container">
          <span class="score-badge"
            >Teka-Teki: <span id="current-question-node">1</span>/<span
              id="total-questions-node"
              >5</span
            ></span
          >
          <span class="score-badge">Skor: <span id="score-node">0</span></span>
        </div>

        <div class="riddle-box">
          <p class="riddle-text" id="riddle-text">Memuat teka-teki...</p>
        </div>

        <div class="input-wrapper">
          <input
            type="text"
            class="answer-input"
            id="answer-input"
            placeholder="Ketik jawabanmu di sini..."
            autocomplete="off"
          />
        </div>

        <button class="action-btn" id="submit-btn" onclick="checkUserAnswer()">
          Jawab ✨
        </button>
        <p class="feedback-message" id="feedback-message"></p>
      </div>

      <!-- SCREEN SELESAI GAME -->
      <div id="end-screen" class="end-screen">
        <h2>Permainan Selesai! 🎉</h2>
        <p id="end-message">
          Luar biasa! Kamu berhasil menjawab seluruh tantangan teka-teki logika
          dengan sangat baik.
        </p>
        <button class="action-btn btn-restart" onclick="resetRiddleGame()">
          Main Lagi 🔄
        </button>
      </div>
    </div>

    <script>
      // Bank Data Teka-Teki (Pertanyaan, Kunci Jawaban Akurat, Alternatif Variasi Jawaban)
      const riddleBank = [
        {
          riddle:
            "Aku selalu ada di depanmu, tapi kamu tidak bisa melihatku. Apakah aku?",
          answers: ["masa depan", "masadepan", "masa-depan"],
        },
        {
          riddle:
            "Miliki aku, kamu ingin membagiku. Bagikan aku, kamu tidak memilikiku lagi. Apakah aku?",
          answers: ["rahasia", "sebuah rahasia", "suatu rahasia"],
        },
        {
          riddle:
            "Semakin banyak kamu mengambilnya, semakin banyak kamu meninggalkannya. Apakah itu?",
          answers: ["langkah kaki", "langkah", "jejak kaki", "jejak"],
        },
        {
          riddle:
            "Aku punya kota, tapi tidak punya rumah. Aku punya hutan, tapi tidak punya pohon. Apakah aku?",
          answers: ["peta", "sebuah peta", "map"],
        },
        {
          riddle:
            "Apa yang penuh dengan lubang, tetapi masih bisa menampung air?",
          answers: ["spons", "sponge", "busa"],
        },
      ];

      let currentLevel = 0;
      let userScore = 0;
      let isWaitingForNext = false;

      // Inisialisasi Game Saat Halaman Dimuat
      window.addEventListener("DOMContentLoaded", () => {
        setupRiddleLevel();

        // Mengizinkan tombol 'Enter' untuk mengirim jawaban
        document
          .getElementById("answer-input")
          .addEventListener("keypress", function (e) {
            if (e.key === "Enter") {
              if (!isWaitingForNext) {
                checkUserAnswer();
              }
            }
          });
      });

      // Setup Level Baru
      function setupRiddleLevel() {
        isWaitingForNext = false;
        document.getElementById("total-questions-node").innerText =
          riddleBank.length;
        document.getElementById("current-question-node").innerText =
          currentLevel + 1;
        document.getElementById("score-node").innerText = userScore;
        document.getElementById("riddle-text").innerText =
          riddleBank[currentLevel].riddle;
        document.getElementById("answer-input").value = "";
        document.getElementById("answer-input").disabled = false;
        document.getElementById("answer-input").focus();
        document.getElementById("feedback-message").innerText = "";
        document.getElementById("feedback-message").className =
          "feedback-message";
        document.getElementById("submit-btn").innerText = "Jawab ✨";
      }

      // Memvalidasi Jawaban User
      function checkUserAnswer() {
        if (isWaitingForNext) {
          advanceNextLevel();
          return;
        }

        const inputField = document.getElementById("answer-input");
        const cleanUserAnswer = inputField.value.trim().toLowerCase();
        const feedback = document.getElementById("feedback-message");
        const submitBtn = document.getElementById("submit-btn");

        if (cleanUserAnswer === "") {
          feedback.innerText = "Masukkan jawaban terlebih dahulu!";
          feedback.className = "feedback-message wrong";
          return;
        }

        const currentValidAnswers = riddleBank[currentLevel].answers;

        // Cek kebenaran jawaban berdasarkan variasi array jawaban
        if (currentValidAnswers.includes(cleanUserAnswer)) {
          feedback.innerText = "Benar sekali! Pintar! 👏🌟";
          feedback.className = "feedback-message correct";
          userScore += 20;
          document.getElementById("score-node").innerText = userScore;
        } else {
          // Tampilkan jawaban yang benar agar user tidak frustrasi dan bebas bug logika gantung
          feedback.innerText = `Kurang tepat. Jawaban yang benar: "${currentValidAnswers[0]}"`;
          feedback.className = "feedback-message wrong";
        }

        inputField.disabled = true;
        isWaitingForNext = true;

        if (currentLevel < riddleBank.length - 1) {
          submitBtn.innerText = "Lanjut ➡️";
        } else {
          submitBtn.innerText = "Lihat Hasil 🎉";
        }
      }

      // Beralih ke Level Selanjutnya atau Selesai
      function advanceNextLevel() {
        if (currentLevel < riddleBank.length - 1) {
          currentLevel++;
          setupRiddleLevel();
        } else {
          showFinalResults();
        }
      }

      // Menampilkan Layar Hasil Akhir
      function showFinalResults() {
        document.getElementById("play-screen").style.display = "none";
        const endScreen = document.getElementById("end-screen");
        endScreen.style.display = "block";

        document.getElementById("end-message").innerText =
          `Selamat! Kamu berhasil menuntaskan seluruh teka-teki dengan skor akhir ${userScore} dari total 100 poin!`;
      }

      // Reset dan Mulai Ulang Game dari Awal
      function resetRiddleGame() {
        currentLevel = 0;
        userScore = 0;
        document.getElementById("play-screen").style.display = "block";
        document.getElementById("end-screen").style.display = "none";
        setupRiddleLevel();
      }
    </script>
  </body>
</html>
