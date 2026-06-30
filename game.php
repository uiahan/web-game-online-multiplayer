<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link rel="stylesheet" href="css/global.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Be+Vietnam+Pro:wght@400;600;700&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@100..900&family=Plus+Jakarta+Sans:wght@100..900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/game.css">
    <script id="tailwind-config" src="tailwind-config.js"></script>
</head>

<body class="bg-background text-on-background font-body-md selection:bg-primary-container selection:text-on-primary-container">
    <!-- TopNavBar -->
    <?php session_start() ?>
    <?php include 'komponen/navbar.php'; ?>
    <main class="max-w-container-max mx-auto xl:pb-40 xl:pt-20 px-gutter py-lg">
        <!-- Hero / Search Section -->
        <header class="flex flex-col md:flex-row md:items-end justify-between gap-md mb-lg">
            <div class="space-y-base">
                <h1 class="font-display-lg text-display-lg text-on-surface">
                    Pilih <span class="text-primary">Game Kamu</span>
                </h1>
                <!-- <p class="font-body-lg text-body-lg text-on-surface-variant max-w-xl">
                    Kumpulan game sederhana yang bisa kamu mainkan kapan saja untuk mengisi waktu luang.
                </p> -->
            </div>

            <!-- Search Bar -->
            <div class="relative w-full md:w-80 group">
                <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none text-outline">
                    <span class="material-symbols-outlined">search</span>
                </div>
                <input class="w-full pl-12 pr-4 py-3 bg-surface-container-low border-2 border-transparent focus:border-primary focus:ring-0 rounded-full font-body-md text-body-md outline-none transition-all duration-300 placeholder:text-outline/60 group-hover:bg-surface-container shadow-sm" placeholder="Cari game favorit..." type="text" />
            </div>
        </header>
        <!-- Filters -->
        <div class="flex flex-wrap items-center gap-sm mb-md p-2 bg-surface-container-low rounded-full w-fit">
            <button class="px-6 py-2 rounded-full font-label-md text-label-md bg-primary text-on-primary transition-all shadow-md bouncy-press">Semua Game</button>
            <button class="px-6 py-2 rounded-full font-label-md text-label-md text-on-surface-variant hover:bg-surface-container-highest transition-all bouncy-press">Online</button>
            <button class="px-6 py-2 rounded-full font-label-md text-label-md text-on-surface-variant hover:bg-surface-container-highest transition-all bouncy-press">Offline</button>
        </div>
        <!-- Bento-style Game Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-md">
            <?php
            include 'koneksi/listgames.php';
            $games = fetchGames();

            if ($games) {
                foreach ($games as $game) {
                    // Tentukan warna label berdasarkan status
                    $labelClass = ($game['label'] == 'Online') ? 'bg-[#A2C4D9] text-white' : 'bg-surface-container text-on-secondary-container';
            ?>
                    <div class="game-card group bg-surface-container-lowest p-4 rounded-lg border border-surface-container-highest transition-all duration-300 hover:scale-[1.02] hover:bg-white soft-shadow flex flex-col" data-label="<?php echo $game['label']; ?>">
                        <div class="relative aspect-video rounded-lg overflow-hidden mb-md">
                            <div class="w-full h-full bg-cover bg-center transition-transform duration-500 group-hover:scale-110"
                                style="background-image: url('<?php echo $game['gambar']; ?>')">
                            </div>
                        </div>
                        <div class="flex-grow">
                            <div class="flex justify-between items-start mb-xs">
                                <h3 class="font-title-md text-title-md text-on-surface"><?php echo $game['judul']; ?></h3>
                                <span class="px-2 py-0.5 rounded-full <?php echo $labelClass; ?> text-label-sm font-label-sm">
                                    <?php echo $game['label']; ?>
                                </span>
                            </div>
                            <p class="font-body-md text-body-md text-on-surface-variant mb-md line-clamp-2">
                                <?php echo $game['deskripsi']; ?>
                            </p>
                        </div>
                        <a href="<?php echo $game['link']; ?>" class="w-full py-3 rounded-full bg-secondary-container text-on-secondary-container font-label-md text-label-md transition-all hover:bg-secondary-fixed-dim bouncy-press flex items-center justify-center gap-sm">
                            Main Sekarang
                            <span class="material-symbols-outlined text-[18px]">play_arrow</span>
                        </a>
                    </div>
            <?php
                }
            } else {
                echo "<p>Tidak ada game tersedia.</p>";
            }
            ?>
        </div>
    </main>
    <!-- Footer -->
    <?php include 'komponen/footer.php'; ?>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const filterButtons = document.querySelectorAll(".flex-wrap button");
            const gameCards = document.querySelectorAll(".game-card");

            filterButtons.forEach((btn) => {
                btn.addEventListener("click", () => {
                    filterButtons.forEach((b) => {
                        b.classList.remove("bg-primary", "text-on-primary", "shadow-md");
                        b.classList.add("text-on-surface-variant", "hover:bg-surface-container-highest");
                    });

                    btn.classList.add("bg-primary", "text-on-primary", "shadow-md");
                    btn.classList.remove("text-on-surface-variant", "hover:bg-surface-container-highest");

                    const filterValue = btn.textContent.trim();

                    gameCards.forEach((card) => {
                        const cardLabel = card.getAttribute("data-label");

                        if (filterValue === "Semua Game" || cardLabel === filterValue) {
                            card.classList.remove("hidden");
                        } else {
                            card.classList.add("hidden");
                        }
                    });
                });
            });

            const searchInput = document.querySelector('input[type="text"]');
            searchInput.addEventListener("input", (e) => {
                const searchTerm = e.target.value.toLowerCase();

                gameCards.forEach((card) => {
                    const title = card.querySelector("h3").textContent.toLowerCase();

                    if (title.includes(searchTerm)) {
                        card.classList.remove("hidden");
                    } else {
                        card.classList.add("hidden");
                    }
                });
            });
        });
    </script>
</body>

</html>