<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>404 - Halaman Tidak Ditemukan</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet" />

    <!-- Config kamu -->
    <script src="tailwind-config.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-surface-container-low flex items-center justify-center min-h-screen px-6">

    <div class="text-center max-w-xl">


        <!-- 404 besar -->
        <h1 class="text-7xl font-extrabold text-primary mb-4">
            404
        </h1>

        <!-- Judul -->
        <h2 class="text-2xl font-semibold text-on-surface mb-3">
            Halaman Tidak Ditemukan
        </h2>

        <!-- Deskripsi -->
        <p class="text-on-surface-variant mb-8">
            Sepertinya kamu tersesat
            Halaman yang kamu cari tidak tersedia atau sudah dipindahkan.
        </p>

        <!-- Tombol -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="/ulinkeun/"
                class="px-8 py-4 bg-primary text-on-primary rounded-full font-semibold hover:scale-105 transition">
                Kembali ke Beranda
            </a>

            <a href="/ulinkeun/game.php"
                class="px-8 py-4 border border-outline-variant rounded-full text-on-surface hover:bg-white/50 transition">
                Lihat Game
            </a>
        </div>

    </div>

</body>

</html>