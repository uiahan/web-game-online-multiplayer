<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<nav class="bg-background dark:bg-background w-full sticky top-0 z-50 bg-surface-container-low backdrop-blur-md shadow-[0_4px_20px_rgba(112,92,74,0.12)]">
    <div class="flex justify-between items-center max-w-container-max mx-auto px-gutter py-4">
        <div class="flex items-center gap-base">
            <span class="font-headline-lg text-headline-lg text-primary tracking-tight">Ulinkeun</span>
        </div>

        <div class="hidden md:flex items-center gap-lg">
            <?php
            $links = ['index.php' => 'Beranda', 'game.php' => 'Koleksi Game', 'about.php' => 'Tentang Kami'];
            foreach ($links as $url => $label):
            ?>
                <a class="font-title-sm text-title-sm transition-colors duration-300 <?php echo ($current_page == $url) ? 'text-primary border-b-2 border-primary pb-1' : 'text-on-surface-variant hover:text-primary'; ?>" href="<?php echo $url; ?>">
                    <?php echo $label; ?>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="hidden md:flex items-center gap-sm">
            <?php if (isset($_SESSION['user'])): ?>
                <div class="relative group">
                    <button class="flex items-center gap-2 px-5 py-2 rounded-full hover:bg-surface-container-high">
                        <span class="text-on-surface-variant">
                            Halo, <?php echo htmlspecialchars($_SESSION['user']['username']); ?>
                        </span>
                        <svg class="w-4 h-4 text-on-surface-variant group-hover:rotate-180 transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['user']['username']); ?>"
                            class="w-8 h-8 rounded-full">
                    </button>
                    <div class="absolute right-0 mt-2 w-56 bg-surface-container-high rounded-2xl shadow-xl border border-outline-variant overflow-hidden hidden group-hover:block transition-all duration-200 transform origin-top-right">
                        <div class="px-4 py-3 border-b border-outline-variant">
                            <p class="text-xs text-on-surface-variant uppercase tracking-wider font-bold">Akun Saya</p>
                            <p class="text-sm font-medium text-on-surface truncate"><?php echo htmlspecialchars($_SESSION['user']['username']); ?></p>
                        </div>
                        <div class="py-1">
                            <a href="koneksi/logout.php" class="flex items-center gap-3 px-4 py-3 text-sm text-error hover:bg-error-container transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Logout
                            </a>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- BELUM LOGIN -->
                <a href="login.php" class="px-gutter py-2 rounded-full font-label-md text-label-md text-on-secondary-container hover:bg-primary-container transition-all">Login</a>
                <a href="daftar.php" class="px-gutter py-2 rounded-full font-label-md text-label-md bg-primary text-on-primary shadow-md">Daftar</a>
            <?php endif; ?>
        </div>
        <a id="mobile-menu-button" class="md:hidden p-2 text-on-surface-variant">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </a>
    </div>
    <div id="mobile-menu" class="hidden md:hidden bg-surface-container-low px-gutter pb-4">
        <div class="flex flex-col">
            <a href="index.php" class="block py-2 text-on-surface">Beranda</a>
            <a href="game.php" class="block py-2 text-on-surface">Koleksi Game</a>
            <a href="about.php" class="block py-2 text-on-surface">Tentang Kami</a>
            <div class="pt-4 flex flex-col gap-2">
                <?php if (isset($_SESSION['user'])): ?>
                    <div class="flex items-center gap-2 mb-2">
                        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['user']['username']); ?>"
                            class="w-8 h-8 rounded-full">
                        <span>Halo, <?php echo $_SESSION['user']['username']; ?></span>
                    </div>
                    <a href="koneksi/logout.php" class="w-full py-2 text-center bg-red-500 text-white rounded-full">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="w-full py-2 text-center border rounded-full">Login</a>
                    <a href="daftar.php" class="w-full py-2 text-center bg-primary text-on-primary rounded-full">Daftar</a>
                <?php endif; ?>

            </div>
        </div>
    </div>
</nav>
<script>
    const btn = document.getElementById('mobile-menu-button');
    const menu = document.getElementById('mobile-menu');

    btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });
</script>