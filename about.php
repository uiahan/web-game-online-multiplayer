<!DOCTYPE html>
<html class="light" lang="id">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Tentang Kami - Ulinkeun</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/about.css">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&amp;family=Be+Vietnam+Pro:wght@400;600;700&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script id="tailwind-config" src="tailwind-config.js"></script>
</head>

<body class="bg-background font-body-md text-body-md selection:bg-primary-container selection:text-on-primary-container">
    <!-- TopNavBar -->
    <?php session_start() ?>
    <?php include 'komponen/navbar.php'; ?>
    <main class="relative overflow-hidden">
        <!-- Floating Illustrations Background -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="absolute top-20 -left-10 w-48 h-48 animate-float opacity-40">
                <img class="w-full h-full object-contain" data-alt="A soft, 3D rendered cartoon cloud with a smiling face, styled in a Japanese kawaii aesthetic with pastel blue and white tones, floating gently against a light cream background." src="https://lh3.googleusercontent.com/aida-public/AB6AXuAYoxJAhdCx4-z7uN1Y6LbOILr-f0Sh76yrTjzn1kzrLFw49fcGyYME9Q_LOPEaOJPiA4Nb5f0Tzw2UZihr4qv08miQe_kTi-phGah9dNktgGuxpSbbG1Ueqy82JcHEeKn-2wwLHQ9IBjj7YvF5rZtTu19nLO9eweH2XEOBjGgfjstsBX1SO-gfDY_dTY2bbn_5mcwWIRAZcuhWMntKhQKZ0WrTweGL_OWQCdzjHH4yAZmcwcc05lgHhmaoYfpAFbxf2GoTZt_CNPQS" />
            </div>
            <div class="absolute top-1/3 -right-12 w-64 h-64 animate-float-delayed opacity-30">
                <img class="w-full h-full object-contain" data-alt="A cute, chubby yellow star character with blushing pink cheeks and tiny hands, rendered in a soft-touch matte 3D style, sparkling with tiny magical particles around it." src="https://lh3.googleusercontent.com/aida-public/AB6AXuCqObKdf2Y0zHhN_lnIMkrdqh8zMmNHV64pXt71aZw9mznrD2NXdLwGitNJgxW-7JhgumaSBjb0zkc5_XU_Qm_Rm2ySnm6i9qjIEpeBbm_fi2n1So6fAyu7gS7XLynRABmzL0p77FQ98D7wRdLSde4u2mMm7QLWPlL_nP_A_L1TjhQexvmEK_223gWC6ieVD4-FN0KKzTO-gevKGONddeBOHnFtCEwjdjjjZ7big4qFwVgpS74xwhz5dH4dB6kp0ENHe09tfD2c273f" />
            </div>
            <div class="absolute bottom-40 left-1/4 w-32 h-32 animate-float opacity-20">
                <img class="w-full h-full object-contain" data-alt="A playful pink bubble-like slime creature with large sparkly eyes and a tiny heart icon hovering above its head, featuring soft lighting and a tactile jelly-like texture." src="https://lh3.googleusercontent.com/aida-public/AB6AXuBcfiFqChsI3q3h1G9Qk3-S4eCDLepTgsV5fOUlR3KVJ02qG9S_mYy5IEZEibiqJkK0LYZAPptjlbBJBRLnhvLXCzkxgCmtGw9J3U0khy-ljaZBLDp-F4NEUDhqnykf_qVUI8hDTBfcyR7dxaQiZHRjUXWpbe8CwXRos-yQTAHyjpvlgcIM-_ItWNX4L_qBe0ulxW8j1V53ac7evIwYTkxctLbTzJtt07tnj8sr1K3tOzaNwLWxhBL_dK781hC36uukOYWFNyYTCLn9" />
            </div>
        </div>
        <!-- Hero Section -->
        <!-- <section class="max-w-container-max mx-auto px-gutter xl xl:pt-20 py-xl text-center relative z-10">
            <h1 class="font-display-lg text-display-lg text-primary mb-md">Menyebarkan Kebahagiaan,<br /><span class="text-tertiary">Satu Game Sekaligus.</span></h1>
            <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto mb-lg">MiniJoy lahir dari keinginan sederhana: membuat dunia sedikit lebih cerah melalui permainan yang menggemaskan dan menenangkan.</p>
            <div class="inline-flex p-1 bg-surface-container rounded-full shadow-inner">
                <span class="px-6 py-2 bg-primary text-on-primary rounded-full font-label-md shadow-sm">Dibentuk</span>
                <span class="px-6 py-2 text-on-surface-variant font-label-md">Sejak 2024</span>
            </div>
        </section> -->
        <!-- Cerita Kami Section -->
        <section class="max-w-container-max mx-auto px-gutter xl:pt-20 py-lg relative z-10">
            <div class="bg-surface-container rounded-xl p-lg md:p-xl flex flex-col md:flex-row gap-xl items-center border border-outline-variant/30 shadow-sm">
                <div class="w-full md:w-1/2 rounded-lg overflow-hidden border-4 border-white shadow-lg rotate-[-2deg] transition-transform hover:rotate-0 duration-500">
                    <img class="w-full aspect-video object-cover" data-alt="A warm and cozy illustration of a small creative studio filled with pastel-colored gaming consoles, fluffy pillows, and glowing monitors." src="https://kfmap.asia/storage/thumbs/storage/photos/ID.SUK.UNIV.BSIUS/ID.SUK.UNIV.BSIUS_2.jpg" />
                </div>
                <div class="w-full md:w-1/2 space-y-md">
                    <h2 class="font-headline-lg text-headline-lg text-tertiary">Cerita Kami</h2>
                    <p class="font-body-md text-body-md text-on-surface text-justify">
                        Kami adalah mahasiswa Universitas Bina Sarana Informatika (UBSI) dari jurusan Sistem Informasi yang tergabung dalam satu kelompok kreatif. Berawal dari tugas dan minat yang sama di dunia teknologi, kami mencoba membangun sesuatu yang tidak hanya berfungsi, tetapi juga menyenangkan.
                    </p>
                    <p class="font-body-md text-body-md text-on-surface text-justify">
                        Tim kami terdiri dari Farhan, Ludra, Phoebe, dan Dhiya. Dengan ide dan kontribusi masing-masing, kami mengembangkan proyek ini sebagai bentuk eksplorasi sekaligus pembelajaran dalam menciptakan pengalaman digital yang interaktif dan menarik.
                    </p>
                    <div class="flex gap-sm">
                        <div class="p-4 bg-tertiary-container/30 rounded-lg flex flex-col items-center flex-1 border border-tertiary/10">
                            <span class="font-display-lg text-display-lg text-tertiary">4</span>
                            <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">Anggota</span>
                        </div>
                        <div class="p-4 bg-primary-container/30 rounded-lg flex flex-col items-center flex-1 border border-primary/10">
                            <span class="font-display-lg text-display-lg text-primary">1</span>
                            <span class="font-label-sm text-label-sm text-on-surface-variant uppercase">Tim</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Tim MiniJoy Section -->
        <section class="max-w-container-max mx-auto xl:py-20 px-gutter py-xl relative z-10">
            <div class="text-center mb-xl">
                <h2 class="font-headline-lg text-headline-lg text-primary mb-sm">Tim Kami</h2>
                <p class="font-body-md text-body-md text-on-surface-variant">
                    Kami adalah mahasiswa Sistem Informasi UBSI yang mengerjakan proyek ini bersama.
                </p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-md">
                <!-- Team Member 1 -->
                <div class="bg-surface-container-low p-sm rounded-lg border border-outline-variant/20 bubbly-hover transition-all duration-300 group text-center">
                    <div class="aspect-square rounded-lg bg-primary-container overflow-hidden mb-md border-4 border-white shadow-sm">
                        <img class="w-full h-full object-cover" data-alt="Nadeko" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRNalxvlcq2PkECLcNjw_pzEoEqg2FrB8jPo3GXeau9j3NYXn78uCkv2sTt&s=10" />
                    </div>
                    <h3 class="font-title-md text-title-md text-on-surface">Farhan Dika</h3>
                    <p class="font-label-md text-label-md text-primary mb-sm">Web Developer</p>
                    <p class="font-body-md text-body-md text-on-surface-variant px-xs">Nadeko istri nya Farhan</p>
                </div>
                <!-- Team Member 2 -->
                <div class="bg-surface-container-low p-sm rounded-lg border border-outline-variant/20 bubbly-hover transition-all duration-300 group text-center">
                    <div class="aspect-square rounded-lg bg-tertiary-container overflow-hidden mb-md border-4 border-white shadow-sm">
                        <img class="w-full h-full object-cover" data-alt="Ado" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcScMo33CH87bSr9j_mDMspbu5nXHu9wRl1lDsO0tUTKfA&s=10" />
                    </div>
                    <h3 class="font-title-md text-title-md text-on-surface">Ludra Izmahendra</h3>
                    <p class="font-label-md text-label-md text-tertiary mb-sm">Database Engineer</p>
                    <p class="font-body-md text-body-md text-on-surface-variant px-xs">Ado istri nya Ludra</p>
                </div>
                <!-- Team Member 3 -->
                <div class="bg-surface-container-low p-sm rounded-lg border border-outline-variant/20 bubbly-hover transition-all duration-300 group text-center">
                    <div class="aspect-square rounded-lg bg-secondary-container overflow-hidden mb-md border-4 border-white shadow-sm">
                        <img class="w-full h-full object-cover" data-alt="Tsukishima" src="https://i.redd.it/opinion-on-tsukishima-v0-9iemioebfn1h1.jpg?width=640&format=pjpg&auto=webp&s=3470c41f0c2ea5d22e97f8d840b3ba9a46e779aa" />
                    </div>
                    <h3 class="font-title-md text-title-md text-on-surface">Dhiyaa Liandra</h3>
                    <p class="font-label-md text-label-md text-secondary mb-sm">UI/UX Artist</p>
                    <p class="font-body-md text-body-md text-on-surface-variant px-xs">Tsukishima suami nya Dhiya</p>
                </div>
                <!-- Team Member 4 -->
                <div class="bg-surface-container-low p-sm rounded-lg border border-outline-variant/20 bubbly-hover transition-all duration-300 group text-center">
                    <div class="aspect-square rounded-lg bg-primary-fixed overflow-hidden mb-md border-4 border-white shadow-sm">
                        <img class="w-full h-full object-cover" data-alt="Reze" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRtQu4e_4HM2bRfvXKv4JwVmZmBtl7733XFcThHwb3agQ&s=10" />
                    </div>
                    <h3 class="font-title-md text-title-md text-on-surface">Phoebe Alexandra</h3>
                    <p class="font-label-md text-label-md text-primary mb-sm">UI/UX Artist</p>
                    <p class="font-body-md text-body-md text-on-surface-variant px-xs">Reze istri nya Phoebe</p>
                </div>
            </div>
        </section>
        <!-- Contact Section -->
        <section class="max-w-container-max mx-auto xl:pt-20 xl:pb-40 px-gutter py-xl relative z-10">
            <div class="bg-white rounded-xl shadow-xl overflow-hidden border border-outline-variant/30 flex flex-col md:flex-row">
                <!-- LEFT -->
                <div class="w-full md:w-1/3 bg-primary text-on-primary p-xl space-y-lg">
                    <h2 class="font-headline-lg text-headline-lg">Kontak Kami</h2>
                    <p class="font-body-md text-body-md opacity-90">
                        Hubungi kami untuk kolaborasi, ide game, atau sekadar ngobrol santai.
                    </p>
                </div>
                <!-- RIGHT (LIST MINIMALIS) -->
                <div class="w-full md:w-2/3 p-xl bg-background">
                    <h3 class="font-title-lg text-title-lg text-on-surface mb-lg">
                        Daftar Kontak
                    </h3>
                    <div class="divide-y divide-outline-variant">
                        <!-- Item -->
                        <div class="flex items-center justify-between py-md group">
                            <div class="flex items-center gap-md">
                                <span class="material-symbols-outlined text-primary">call</span>
                                <div>
                                    <p class="text-sm text-on-surface-variant">Telepon</p>
                                    <p class="text-on-surface font-medium">+62 895-1909-4253</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between py-md group">
                            <div class="flex items-center gap-md">
                                <span class="material-symbols-outlined text-tertiary">email</span>
                                <div>
                                    <p class="text-sm text-on-surface-variant">Email</p>
                                    <p class="text-on-surface font-medium">ulinkeun@gmail.com</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between py-md group">
                            <div class="flex items-center gap-md">
                                <span class="material-symbols-outlined text-secondary">group</span>
                                <div>
                                    <p class="text-sm text-on-surface-variant">Komunitas</p>
                                    <p class="text-on-surface font-medium">Discord Ulinkeun (Coming Soon)</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between py-md group">
                            <div class="flex items-center gap-md">
                                <span class="material-symbols-outlined text-primary">schedule</span>
                                <div>
                                    <p class="text-sm text-on-surface-variant">Jam Aktif</p>
                                    <p class="text-on-surface font-medium">09.00 - 21.00 WIB</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- Footer -->
    <?php include 'komponen/footer.php'; ?>
    <script src="js/about.js"></script>
</body>

</html>