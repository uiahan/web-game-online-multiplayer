const SUPABASE_URL = "https://vgqzzmghoyfhwukksbzv.supabase.co";
const SUPABASE_KEY = "sb_publishable_ZZmh_NNgicmaPLY2HXO2yw_am3UB8h4";

const client = window.supabase.createClient(
  SUPABASE_URL,
  SUPABASE_KEY
);

let roomId = new URLSearchParams(window.location.search).get("room");
let player = null;
let currentRoom = null;
let lastAnnouncedResult = "";
let syncTimer = null;

const boardDiv = document.getElementById("board");
const statusMessage = document.getElementById("statusText");
const statusIcon = document.getElementById("statusIcon");
const roomInfo = document.getElementById("roomInfoText");
const roomInfoPill = document.getElementById("roomInfo");
const roleInfo = document.getElementById("roleInfo");
const statusStrip = document.getElementById("statusStrip");
const statusCard = document.getElementById("statusCard");
const shareWhatsAppBtn = document.getElementById("shareWhatsAppBtn");
const gameModal = document.getElementById("gameModal");
const gameModalText = document.getElementById("gameModalText");
const gameModalCloseBtn = document.getElementById("gameModalCloseBtn");

function getWinner(board) {
  return checkWinner(board);
}

function renderBoard(board, room) {
  boardDiv.innerHTML = "";
  board.split("").forEach((cell, i) => {
    const btn = document.createElement("button");
    btn.className = "cell" + (cell === "X" ? " x" : cell === "O" ? " o" : "");
    btn.innerText = cell === "-" ? "" : cell;
    btn.setAttribute("aria-label", `Cell ${i + 1}${cell === '-' ? '' : ': ' + cell}`);
    const canPlay = !!room && !getWinner(room.board) && room.turn === player && room.player_x && room.player_o;
    btn.disabled = !canPlay || cell !== "-";
    btn.onclick = () => makeMove(i);
    boardDiv.appendChild(btn);
  });
}

function checkWinner(board) {
  const win = [
    [0,1,2],[3,4,5],[6,7,8],
    [0,3,6],[1,4,7],[2,5,8],
    [0,4,8],[2,4,6]
  ];

  for (let combo of win) {
    const [a,b,c] = combo;
    if (board[a] !== "-" && board[a] === board[b] && board[a] === board[c]) {
      return board[a];
    }
  }

  if (!board.includes("-")) return "draw";
  return null;
}

function getOutcomeKey(room, winner) {
  return `${room.id}:${room.board}:${room.turn}:${winner}`;
}

function shortRoomCode(roomIdValue) {
  if (!roomIdValue) return "-";
  if (roomIdValue.length <= 8) return roomIdValue;
  return `${roomIdValue.slice(0, 4)}…${roomIdValue.slice(-4)}`;
}

function announceOutcome(room, winner) {
  if (!winner) return;

  const outcomeKey = getOutcomeKey(room, winner);
  if (lastAnnouncedResult === outcomeKey) return;

  lastAnnouncedResult = outcomeKey;

  const message = winner === "draw"
    ? "Permainan berakhir seri."
    : `${winner} memenangkan permainan.`;

  openOutcomeModal(
    winner === "draw" ? "Hasil seri" : "Selamat",
    message
  );

  // ⏳ Countdown
  let countdown = 10;
  gameModalText.innerText = `${message} (Reset dalam ${countdown}s)`;

  const interval = setInterval(() => {
    countdown--;

    gameModalText.innerText = `${message} (Reset dalam ${countdown}s)`;

    if (countdown <= 0) {
      clearInterval(interval);
    }
  }, 1000);

  let resetTimeout = null;

  // ⏳ Reset setelah 10 detik
 resetTimeout = setTimeout(() => {
  resetGame();
}, 10000);

  // Jika modal ditutup sebelum reset, batalkan reset
  gameModalCloseBtn.onclick = () => {
    clearTimeout(resetTimeout);
    clearInterval(interval);
    closeOutcomeModal();
  };
}

function openOutcomeModal(title, message) {
  document.getElementById("gameModalTitle").innerText = title;
  gameModalText.innerText = message;
  gameModal.classList.add("is-open");
  gameModal.setAttribute("aria-hidden", "false");
}

function closeOutcomeModal() {
  gameModal.classList.remove("is-open");
  gameModal.setAttribute("aria-hidden", "true");
}

async function createRoom() {
  const { data } = await client.from("rooms").insert({
    board: "---------",
    turn: "X",
    player_x: null,
    player_o: null
  }).select().single();

  window.location.href = "?room=" + data.id;
}

async function joinRoom() {
  const { data: room, error } = await client
    .from("rooms")
    .select("*")
    .eq("id", roomId)
    .single();

  if (error || !room) {
    statusMessage.innerText = "Room tidak ditemukan. Buat room baru atau cek link room-nya.";
    statusIcon.innerText = "!";
    statusStrip.className = "status-strip state-opponent-turn";
    statusStrip.classList.add("state-opponent-turn");
    roleInfo.innerText = "Kamu belum masuk ke room.";
    roomInfo.innerText = "Room: -";
    roomInfoPill.title = "Room: -";
    return false;
  }

  if (!room.player_x) {
    player = "X";
    localStorage.setItem("player", player);
    await client.from("rooms").update({ player_x: "joined" }).eq("id", roomId);
  } else if (!room.player_o) {
    player = "O";
    localStorage.setItem("player", player);
    await client.from("rooms").update({ player_o: "joined" }).eq("id", roomId);
  } else {
    player = localStorage.getItem("player");
  }

  return true;
}

function renderRoom(room) {
  currentRoom = room;

  renderBoard(room.board, room);

  const winner = getWinner(room.board);
  const shortCode = shortRoomCode(room.id);
  roomInfo.innerText = `Room: ${shortCode}`;
  roomInfoPill.title = `Room: ${room.id}`;
  // roleInfo.innerText = player ? `Kamu bermain sebagai ${player}` : "Kamu sedang menonton";

  statusCard.classList.remove("state-waiting", "state-my-turn", "state-opponent-turn", "state-finished");
  statusStrip.classList.remove("state-waiting", "state-my-turn", "state-opponent-turn", "state-finished");

  if (winner) {
    statusCard.classList.add("state-finished");
    statusStrip.classList.add("state-finished");
    statusIcon.innerText = "✓";
  } else if (!room.player_x || !room.player_o) {
    statusCard.classList.add("state-waiting");
    statusStrip.classList.add("state-waiting");
    statusIcon.innerText = "⌛";
  } else if (player && room.turn === player) {
    statusCard.classList.add("state-my-turn");
    statusStrip.classList.add("state-my-turn");
    statusIcon.innerText = "●";
  } else {
    statusCard.classList.add("state-opponent-turn");
    statusStrip.classList.add("state-opponent-turn");
    statusIcon.innerText = "•";
  }

  announceOutcome(room, winner);

  if (winner === "draw") {
    statusMessage.innerText = "Permainan selesai, hasilnya seri.";
    return;
  }

  if (winner) {
    statusMessage.innerText = winner === player ? "Kamu menang!" : `Pemenang: ${winner}`;
    return;
  }

  if (!room.player_x || !room.player_o) {
    if (!room.player_x && !room.player_o) {
      statusMessage.innerText = "Menunggu pemain pertama.";
    } else {
      statusMessage.innerText = "Menunggu satu pemain lagi.";
    }
    return;
  }

  if (!player) {
    statusMessage.innerText = "Kamu sedang menonton permainan ini.";
    return;
  }

  if (room.turn === player) {
    statusMessage.innerText = `Giliran ${player}`;
  } else {
    statusMessage.innerText = `Giliran ${room.turn}`;
  }
}

async function refreshRoom() {
  if (!roomId) return;

  const { data: room } = await client
    .from("rooms")
    .select("*")
    .eq("id", roomId)
    .single();

  if (room) {
    updateUI(room);
  }
}

async function makeMove(index) {
  if (!currentRoom) return;

  const winnerBeforeMove = getWinner(currentRoom.board);
  if (winnerBeforeMove || currentRoom.turn !== player) return;

  const { data: room } = await client
    .from("rooms")
    .select("*")
    .eq("id", roomId)
    .single();

  if (!room) return;

  if (room.turn !== player) return;

  let board = room.board.split("");

  if (board[index] !== "-") return;

  board[index] = player;

  const winner = checkWinner(board.join(""));
  const nextTurn = player === "X" ? "O" : "X";
  const updatedRoom = {
    ...room,
    board: board.join(""),
    turn: winner ? room.turn : nextTurn
  };

  await client.from("rooms").update({
    board: updatedRoom.board,
    turn: updatedRoom.turn
  }).eq("id", roomId);

  renderRoom(updatedRoom);
}

function getShareUrl() {
  const url = new URL(window.location.href);
  if (roomId) {
    url.searchParams.set("room", roomId);
  }
  return url.toString();
}

async function shareRoomToWhatsApp() {
  const shareUrl = getShareUrl();
  const text = `Yuk main TicTacToe bareng di room ini: ${shareUrl}`;
  const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(text)}`;

  window.open(whatsappUrl, "_blank", "noopener,noreferrer");
}

function updateUI(room) {
  renderRoom(room);
}

async function init() {
  if (!roomId) {
    await createRoom();
    return;
  }

  const joined = await joinRoom();
  if (!joined) return;

  await refreshRoom();

  if (syncTimer) clearInterval(syncTimer);
  syncTimer = setInterval(refreshRoom, 1500);

  window.addEventListener("focus", refreshRoom);
  document.addEventListener("visibilitychange", () => {
    if (!document.hidden) {
      refreshRoom();
    }
  });

  client
    .channel("room-" + roomId)
    .on(
      "postgres_changes",
      { event: "*", schema: "public", table: "rooms", filter: `id=eq.${roomId}` },
      payload => {
        if (payload.new) {
          updateUI(payload.new);
        }
      }
    )
    .subscribe();
}

async function resetGame() {
  if (!roomId) return;

  await client.from("rooms").update({
    board: "---------",
    turn: "X"
  }).eq("id", roomId);

  closeOutcomeModal();
  lastAnnouncedResult = "";
}

shareWhatsAppBtn.addEventListener("click", shareRoomToWhatsApp);
// gameModalCloseBtn.addEventListener("click", closeOutcomeModal);
// gameModal.addEventListener("click", event => {
//   if (event.target === gameModal) {
//     closeOutcomeModal();
//   }
// });

init();