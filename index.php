<?php
$request = $_SERVER['REQUEST_URI'];
$base = '';
$path = str_replace($base, '', $request);

// daftar halaman yang valid
$allowed = [
    '/',
    '/index.php',
    '/about.php',
    '/login.php',
    '/daftar.php',
    '/game.php',
    '/cetak-kartu.php'
];

if (!in_array($path, $allowed)) {
    http_response_code(404);
    include '404.php';
    exit;
}
?>

<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Ulinkeun - Main Seru Setiap Hari!</title>
    <link rel="stylesheet" href="css/global.css">
    <script
        src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Be+Vietnam+Pro:wght@400;600;700&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@100..900&family=Plus+Jakarta+Sans:wght@100..900&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="css/home.css">
    <script id="tailwind-config" src="tailwind-config.js"></script>
</head>

<body
    <?php
    session_start();
    ?>
    class="font-body-md text-body-md selection:bg-primary-container selection:text-on-primary-container">
    <!-- Top Navigation Bar -->
    <?php include 'komponen/navbar.php'; ?>
    <!-- Hero Section -->
    <section class="relative overflow-hidden xl:pt-40 xl:pb-40 pt-xl pb-20 px-gutter">
        <!-- Background Decorations -->
        <div
            class="absolute -top-20 -left-20 w-80 h-80 bg-primary-container/30 rounded-full blur-3xl -z-10"></div>
        <div
            class="absolute top-1/2 -right-40 w-96 h-96 bg-tertiary-container/20 rounded-full blur-3xl -z-10"></div>
        <div
            class="max-w-container-max mx-auto grid grid-cols-1 lg:grid-cols-2 gap-xl items-center">
            <div class="relative">

                <!-- Hero Image -->
                <div class="floating-element relative z-10 rounded-xl overflow-hidden shadow-2xl border-8 border-white">
                    <img class="w-full aspect-video object-cover"
                        src="https://wallpapercave.com/wp/wp4091400.png" />
                </div>

                <!-- Badge 1 -->
                <div
                    class="absolute top-2 right-2 md:-top-6 md:-right-6 z-20 bg-white p-2 md:p-4 rounded-lg shadow-lg rotate-6 md:rotate-12 flex items-center gap-2 md:gap-sm scale-90 md:scale-100">

                    <div class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-tertiary-container flex items-center justify-center">
                        <span class="material-symbols-outlined text-on-tertiary-container text-sm md:text-base"
                            style="font-variation-settings: 'FILL' 1;">favorite</span>
                    </div>

                    <div>
                        <p class="text-[10px] md:text-sm text-on-surface-variant">Yuk Kita</p>
                        <p class="text-xs md:text-sm font-medium">Main Sekarang</p>
                    </div>
                </div>

                <!-- Badge 2 -->
                <div
                    class="absolute bottom-2 left-2 md:-bottom-10 md:-left-10 z-20 glass-panel p-3 md:p-6 rounded-lg shadow-xl -rotate-3 md:-rotate-6 flex items-center gap-2 md:gap-md scale-90 md:scale-100">

                    <div class="flex -space-x-3 md:-space-x-4">
                        <div class="w-8 h-8 md:w-10 md:h-10 rounded-full border-2 border-white bg-primary-fixed"></div>
                        <div class="w-8 h-8 md:w-10 md:h-10 rounded-full border-2 border-white bg-secondary-fixed"></div>
                        <div class="w-8 h-8 md:w-10 md:h-10 rounded-full border-2 border-white bg-tertiary-fixed"></div>
                    </div>

                    <p class="text-xs md:text-sm text-on-surface">Main Multiplayer</p>
                </div>

            </div>
            <div class="space-y-md xl:text-center lg:text-left">
                <div
                    class="inline-flex items-center gap-xs px-4 py-2 rounded-full bg-secondary-container text-on-secondary-container font-label-sm text-label-sm shadow-sm">
                    <span
                        class="material-symbols-outlined text-[18px]">celebration</span>
                    <span>Main Game Gratis & Seru</span>
                </div>
                <h1
                    class="font-display-lg text-display-lg text-on-surface leading-tight">
                    Main Seru Setiap Hari di <span
                        class="text-primary">Ulinkeun!</span>
                </h1>
                <p
                    class="font-body-lg text-body-lg text-on-surface-variant max-w-xl mx-auto lg:mx-0">
                    Temukan koleksi game paling seru
                    untuk menemani waktu luangmu. Tanpa instal, langsung
                    main!
                </p>
                <div
                    class="flex flex-col sm:flex-row items-center gap-md pt-base justify-center lg:justify-start">
                    <a
                        href="#why"
                        class="bouncy-button w-full sm:w-auto px-10 py-5 bg-primary text-on-primary rounded-full font-title-md text-title-md flex items-center justify-center gap-sm">
                        Jelajahi Sekarang
                        <span
                            class="material-symbols-outlined">rocket_launch</span>
                    </a>
                    <a
                        href="game.php"
                        class="secondary-bouncy text-center w-full sm:w-auto px-10 py-5 bg-surface-container-highest text-secondary rounded-full font-title-md text-title-md border-2 border-outline-variant/30">
                        Koleksi Game
                    </a>
                </div>
            </div>

        </div>
    </section>
    <!-- Why Play Section -->
    <section id="why" class="py-xl px-gutter xl:pt-40 bg-surface-container-low">
        <div class="max-w-container-max mx-auto">
            <div class="xl:text-center mb-lg">
                <h2
                    class="font-headline-lg text-headline-lg text-on-surface mb-base">Kenapa
                    Bermain di Ulinkeun?</h2>

            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-md">
                <!-- Card 1 -->
                <div
                    class="bg-surface p-8 rounded-lg border-2 border-surface-container-highest shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex justify-center">
                        <div
                            class="w-24 h-24 rounded-full bg-primary-container flex items-center justify-center mb-md">
                            <span
                                class="material-symbols-outlined text-primary text-[50px]">flash_on</span>
                        </div>
                    </div>
                    <h3
                        class="font-title-md text-title-md text-on-surface mb-sm">Tanpa
                        Download</h3>
                    <p
                        class="font-body-md text-body-md text-on-surface-variant">Buka
                        browsermu dan langsung mainkan game tanpa
                        harus menunggu unduhan selesai.</p>
                </div>
                <!-- Card 2 -->
                <div
                    class="bg-surface p-8 rounded-lg border-2 border-surface-container-highest shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex justify-center">
                        <div
                            class="w-24 h-24 rounded-full bg-tertiary-container flex items-center justify-center mb-md">
                            <span
                                class="material-symbols-outlined text-tertiary text-[50px]">sentiment_very_satisfied</span>
                        </div>
                    </div>
                    <h3
                        class="font-title-md text-title-md text-on-surface mb-sm">100%
                        Gratis</h3>
                    <p
                        class="font-body-md text-body-md text-on-surface-variant">Nikmati
                        seluruh koleksi game kami secara cuma-cuma selamanya
                        tanpa biaya tersembunyi.</p>
                </div>
                <!-- Card 3 -->
                <div
                    class="bg-surface p-8 rounded-lg border-2 border-surface-container-highest shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex justify-center">
                        <div
                            class="w-24 h-24 rounded-full bg-secondary-fixed flex items-center justify-center mb-md">
                            <span
                                class="material-symbols-outlined text-secondary text-[50px]">update</span>
                        </div>
                    </div>
                    <h3
                        class="font-title-md text-title-md text-on-surface mb-sm">Update
                        Game Baru</h3>
                    <p
                        class="font-body-md text-body-md text-on-surface-variant">Kami
                        selalu menambahkan game-game baru yang lucu dan
                        menantang.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Stats & CTA Section -->
    <section class="pb-xl xl:pb-40 px-gutter relative bg-surface-container-low">
        <div
            class="max-w-container-max mx-auto bg-primary-container/30 rounded-xl p-lg relative overflow-hidden border-4 border-white shadow-xl">
            <div class="absolute -bottom-10 -right-10 opacity-10">
                <span
                    class="material-symbols-outlined text-[300px]">videogame_asset</span>
            </div>
            <div
                class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-lg">
                <div class="max-w-xl lg:text-left">
                    <h2
                        class="font-display-lg text-start text-headline-lg text-on-primary-container mb-md">Sudah
                        Siap Untuk Keseruan?</h2>
                    <p
                        class="font-body-lg text-body-lg text-start text-on-primary-container/80 mb-md">Gabung
                        bersama pemain lainnya sekarang juga dan
                        mulai petualanganmu di dunia Ulinkeun!</p>
                    <!-- <div
                        class="flex flex-wrap gap-md justify-center lg:justify-start">
                        <div class="text-center">
                            <p
                                class="font-display-lg text-headline-lg text-primary">1M+</p>
                            <p
                                class="font-label-md text-label-md text-on-surface-variant">Total
                                Main</p>
                        </div>
                        <div
                            class="h-12 w-[1px] bg-outline-variant/50 self-center hidden sm:block"></div>
                        <div class="text-center">
                            <p
                                class="font-display-lg text-headline-lg text-primary">200+</p>
                            <p
                                class="font-label-md text-label-md text-on-surface-variant">Game
                                Baru</p>
                        </div>
                        <div
                            class="h-12 w-[1px] bg-outline-variant/50 self-center hidden sm:block"></div>
                        <div class="text-center">
                            <p
                                class="font-display-lg text-headline-lg text-primary">99%</p>
                            <p
                                class="font-label-md text-label-md text-on-surface-variant">User
                                Happy</p>
                        </div>
                    </div> -->
                </div>
                <div class="flex flex-col gap-sm w-full lg:w-auto">
                    <a href="daftar.php"
                        class="bouncy-button text-center px-12 py-5 bg-primary text-on-primary rounded-full font-title-md text-title-md flex items-center justify-center gap-sm">
                        Daftar Gratis Sekarang
                        <!-- <span
                            class="material-symbols-outlined">person_add</span> -->
                    </a>
                    <!-- <p
                        class="text-center font-label-sm text-label-sm text-on-surface-variant">Proses
                        daftar hanya butuh 30 detik!</p> -->
                </div>
            </div>
        </div>
    </section>
    <!-- Footer -->
    <?php include 'komponen/footer.php'; ?>
    <script src="js/home.js"></script>
</body>

</html>