<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Daftar Ulinkeun - Bergabung dengan Keceriaan</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&amp;family=Be+Vietnam+Pro:wght@400;600;700&amp;display=swap" rel="stylesheet" />
    <!-- Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config" src="tailwind-config.js"></script>
    <link rel="stylesheet" href="css/daftar.css">
</head>

<body class="font-body-md text-on-surface overflow-x-hidden">
    <!-- Top Navigation (Shell Rule: Suppressed for Transactional pages, but here we provide a minimal brand header) -->
    <header class="w-full py-6 px-gutter flex justify-center items-center">
        <div class="flex items-center gap-2">
            <!-- <span class="font-headline-lg text-headline-lg text-primary tracking-tight">MiniJoy</span>
            <div class="w-2 h-2 rounded-full bg-tertiary mt-2"></div> -->
        </div>
    </header>
    <main class="flex items-center justify-center min-h-[calc(100vh-160px)] px-gutter pb-xl relative">
        <!-- Decorative Floating Elements -->
        <div class="absolute top-20 left-10 w-24 h-24 bg-primary-container rounded-full opacity-20 blur-xl floating-element" style="animation-delay: 0s;"></div>
        <div class="absolute bottom-20 right-10 w-32 h-32 bg-tertiary-container rounded-full opacity-20 blur-xl floating-element" style="animation-delay: 1s;"></div>
        <div class="absolute top-1/2 left-20 w-16 h-16 bg-secondary-container rounded-full opacity-20 blur-xl floating-element" style="animation-delay: 2s;"></div>
        <!-- Register Card -->
        <div class="w-full max-w-[520px] bg-white rounded-lg p-md md:p-lg soft-shadow border border-surface-container-high relative z-10">
            <div class="text-center mb-lg">
                <h1 class="font-headline-lg text-headline-lg text-on-surface mb-2">Buat Akun Baru</h1>
                <!-- <p class="font-body-md text-on-surface-variant">Bergabunglah untuk mulai mengoleksi keceriaan di MiniJoy!</p> -->
            </div>
            <form method="POST" action="koneksi/daftar.php" class="space-y-6" id="registerForm">
                <!-- Full Name -->
                <div class="space-y-2">
                    <label class="font-label-md text-label-md text-on-surface-variant ml-2" for="full_name">Nama Lengkap</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">person</span>
                        <input class="w-full pl-12 pr-4 py-4 bg-surface-container-low border-2 border-transparent rounded-full font-body-md text-on-surface placeholder:text-outline/50 focus:border-primary focus:outline-none input-soft" id="full_name" name="nama_lengkap" placeholder="Budi Joy" required="" type="text" />
                    </div>
                </div>
                <!-- Email -->
                <div class="space-y-2">
                    <label class="font-label-md text-label-md text-on-surface-variant ml-2" for="email">Email</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">mail</span>
                        <input class="w-full pl-12 pr-4 py-4 bg-surface-container-low border-2 border-transparent rounded-full font-body-md text-on-surface placeholder:text-outline/50 focus:border-primary focus:outline-none input-soft" id="email" name="email" placeholder="budi@minijoy.com" required="" type="email" />
                    </div>
                </div>
                <!-- Username -->
                <div class="space-y-2">
                    <label class="font-label-md text-label-md text-on-surface-variant ml-2" for="username">Username</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">alternate_email</span>
                        <input class="w-full pl-12 pr-4 py-4 bg-surface-container-low border-2 border-transparent rounded-full font-body-md text-on-surface placeholder:text-outline/50 focus:border-primary focus:outline-none input-soft" id="username" name="username" placeholder="budijoy24" required="" type="text" />
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Password -->
                    <div class="space-y-2">
                        <label class="font-label-md text-label-md text-on-surface-variant ml-2" for="password">Password</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">lock</span>
                            <input class="w-full pl-12 pr-4 py-4 bg-surface-container-low border-2 border-transparent rounded-full font-body-md text-on-surface placeholder:text-outline/50 focus:border-primary focus:outline-none input-soft" id="password" name="password" placeholder="••••••••" required="" type="password" />
                        </div>
                    </div>
                    <!-- Confirm Password -->
                    <div class="space-y-2">
                        <label class="font-label-md text-label-md text-on-surface-variant ml-2" for="confirm_password">Konfirmasi</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">verified_user</span>
                            <input class="w-full pl-12 pr-4 py-4 bg-surface-container-low border-2 border-transparent rounded-full font-body-md text-on-surface placeholder:text-outline/50 focus:border-primary focus:outline-none input-soft" id="confirm_password" name="confirm_password" placeholder="••••••••" required="" type="password" />
                        </div>
                    </div>
                </div>
                <!-- Terms -->
                <!-- <div class="flex items-center gap-3 ml-2">
                    <input class="w-5 h-5 rounded-full border-2 border-primary text-primary focus:ring-primary/20 bg-surface-container-low" id="terms" name="terms" required="" type="checkbox" />
                    <label class="font-label-sm text-label-sm text-on-surface-variant" for="terms">
                        Saya setuju dengan <a class="text-primary hover:underline" href="#">Syarat &amp; Ketentuan</a> yang berlaku.
                    </label>
                </div> -->
                <!-- Submit Button -->
                <button class="w-full button py-4 bg-primary text-white font-title-md text-title-md rounded-full bubbly-button hover:bg-primary/90 transition-all flex justify-center items-center gap-2" type="submit">
                    Daftar Sekarang
                    <span class="material-symbols-outlined">arrow_forward</span>
                </button>
            </form>
            <!-- Login Link -->
            <div class="mt-lg pt-md border-t border-surface-container-highest text-center">
                <p class="font-body-md text-on-surface-variant">
                    Sudah punya akun?
                    <a class="text-tertiary font-bold hover:underline ml-1" href="login.php">Masuk</a>
                </p>
            </div>
        </div>
        <script src="js/daftar.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            document.getElementById('registerForm').addEventListener('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);

                fetch('koneksi/daftar.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Mantap!',
                                text: data.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = 'login.php'; // Pindah ke login setelah sukses
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: data.message
                            });
                        }
                    });
            });
        </script>
</body>

</html>