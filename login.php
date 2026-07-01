<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Login - MiniJoy</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&amp;family=Be+Vietnam+Pro:wght@400;600;700&amp;display=swap" rel="stylesheet" />
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config" src="tailwind-config.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/login.css">
</head>

<body class="min-h-screen flex items-center justify-center p-gutter font-body-md text-on-background">
    <!-- Main Container -->
    <main class="w-full max-w-[900px] grid md:grid-cols-2 gap-lg items-center">
        <!-- Left Side: Illustration & Branding (Hidden on mobile or stacked) -->
        <div class="hidden md:flex flex-col items-center justify-center text-center space-y-md kawaii-float">
            <div class="relative w-full aspect-square max-w-[320px]">
                <!-- Mascot Illustration Placeholder -->
                <img class="w-full h-full object-contain rounded-lg object-cover" data-alt="A cute, chubby pastel blue dinosaur mascot with rosy cheeks and large expressive eyes, sitting happily. The style is 3D clay-morphism with soft, rounded edges and gentle lighting. The background is a soft peach gradient with floating colorful gaming icons like a controller and a star, matching the MiniJoy brand colors of sky blue and warm brown." src="https://wallpapercave.com/wp/wp4091400.png" />
            </div>
            <div class="space-y-sm">
                <h1 class="font-display-lg text-display-lg text-primary tracking-tight">Ulinkeun</h1>
                <!-- <p class="font-body-lg text-body-lg text-on-surface-variant px-md">
                    Temukan kebahagiaan kecilmu di setiap permainan!
                </p> -->
            </div>
        </div>
        <!-- Right Side: Login Card -->
        <div class="w-full bg-surface-container-lowest p-lg rounded-xl bubbly-shadow border-2 border-surface-container-highest">
            <!-- Mobile Logo -->
            <div class="md:hidden text-center mb-md">
                <h1 class="font-headline-lg-mobile text-headline-lg-mobile text-primary">Ulinkeun</h1>
            </div>
            <header class="mb-lg">
                <h2 class="font-headline-lg text-headline-lg text-on-surface">Selamat Datang!</h2>
                <!-- <p class="font-body-md text-body-md text-on-surface-variant">Senang melihatmu kembali di dunia Ulinkeun.</p> -->
            </header>
            <form method="POST" action="koneksi/login.php" class="space-y-md" id="loginForm">
                <!-- Username Field -->
                <div class="space-y-base">
                    <label class="font-label-md text-label-md text-secondary ml-xs" for="username">Username</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">person</span>
                        <input class="w-full pl-12 pr-4 py-4 bg-surface-container-low border-2 border-surface-container-highest rounded-full font-body-md focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all placeholder:text-outline-variant" id="username" name="username" placeholder="Masukkan username" type="text" />
                    </div>
                </div>
                <!-- Password Field -->
                <div class="space-y-base">
                    <label class="font-label-md text-label-md text-secondary ml-xs" for="password">Kata Sandi</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">lock</span>
                        <input class="w-full pl-12 pr-12 py-4 bg-surface-container-low border-2 border-surface-container-highest rounded-full font-body-md focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all placeholder:text-outline-variant" id="password" name="password" placeholder="Masukkan kata sandi" type="password" />
                        <button class="absolute right-4 top-1/2 -translate-y-1/2 text-outline hover:text-primary" type="button">
                            <span class="material-symbols-outlined" id="togglePassword">visibility</span>
                        </button>
                    </div>
                    <!-- <div class="flex justify-end px-xs">
                        <a class="font-label-sm text-label-sm text-primary hover:underline underline-offset-4" href="#">Lupa kata sandi?</a>
                    </div> -->
                </div>
                <!-- Submit Button -->
                <button class="w-full py-4 bg-primary text-on-primary font-title-md text-title-md rounded-full bubbly-button hover:bg-surface-tint active:scale-95 transition-all flex items-center justify-center gap-base mt-lg" type="submit">
                    <span>Masuk Ke Ulinkeun</span>
                    <span class="material-symbols-outlined">rocket_launch</span>
                </button>
            </form>
            <!-- Registration Footer -->
            <footer class="mt-lg pt-lg border-t-2 border-surface-container-low text-center">
                <p class="font-body-md text-body-md text-on-surface-variant">
                    Belum punya akun?
                    <a href="daftar.php" class="text-tertiary font-bold hover:underline decoration-tertiary decoration-2 underline-offset-4 ml-xs transition-all">Daftar</a>
                </p>
            </footer>
        </div>
    </main>
    <!-- Footer Copyright -->
    <!-- <div class="fixed bottom-gutter left-0 w-full text-center pointer-events-none">
        <p class="font-label-sm text-label-sm text-outline opacity-60">© 2024 Ulinkeun Playroom. Dibuat dengan penuh keceriaan.</p>
    </div> -->
    <script src="js/login.js"></script>
    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Mencegah reload halaman

            let formData = new FormData(this);

            fetch('koneksi/login.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: data.message,
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = '/ulinkeun'; // Pindah setelah alert
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: data.message
                        });
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
</body>

</html>