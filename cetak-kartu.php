<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Kartu Member Imut - <?php echo $_SESSION['user']['username']; ?></title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&display=swap');

        :root {
            --panel: #f8f1e8;
            --panel-border: #d6c5b0;
            --text: #7b604c;
        }

        @media print {

            /* 1. Paksa ukuran kertas sesuai kartu */
            @page {
                size: 105mm 65mm;
                margin: 0 !important;
            }

            /* 2. Hilangkan margin body */

            body {
                margin: 0 !important;
                padding: 0 !important;
                /* Perintah wajib agar warna background ikut tercetak */
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            /* Pastikan elemen kartu memiliki background */
            #kartu {
                background-color: #f8f1e8 !important;
                /* Warna panel Anda */
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                margin: 0 !important;
                border: 2px solid #d6c5b0 !important;
            }

            /* 3. Pastikan tidak ada elemen yang membuat overflow */
            .no-print {
                display: none !important;
            }

        }

        body {
            font-family: 'Quicksand', sans-serif;
        }

        #kartu {
            width: 105mm;
            height: 65mm;
            background: linear-gradient(135deg, #f8f1e8 0%, #fdf9f4 100%);
            border: 4px solid #f1e3d1;
            box-shadow: 0 10px 25px rgba(112, 92, 74, 0.15);
        }
    </style>
</head>

<body class="bg-[#A2C4D9] flex flex-col items-center justify-center min-h-screen p-4">

    <div id="kartu" class="rounded-[2rem] p-6 flex gap-6 items-center relative overflow-hidden">
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-[#A2C4D9] opacity-20 rounded-full"></div>

        <div class="relative flex-shrink-0">
            <div class="absolute -inset-1 bg-[#d6c5b0] rounded-full blur-[2px]"></div>
            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['user']['username']); ?>&background=A2C4D9&color=fff&size=256"
                class="relative w-24 h-24 rounded-full border-4 border-white shadow-lg">
        </div>

        <div class="flex flex-col justify-center text-[#7b604c]">
            <span class="text-[10px] uppercase tracking-widest font-bold opacity-60">Member Card</span>
            <h2 class="text-xl font-bold"><?php echo $_SESSION['user']['nama_lengkap'] ?? 'Nama User'; ?></h2>
            <p class="text-sm font-medium text-[#9a7b63]">@<?php echo $_SESSION['user']['username']; ?></p>

            <div class="mt-4 flex flex-col gap-1 text-xs">
                <div class="flex items-center gap-2">
                    <span>💌</span> <?php echo $_SESSION['user']['email'] ?? 'halo@email.com'; ?>
                </div>
                <div class="flex items-center gap-2">
                    <span>⭐</span> ID: ULC-<?php echo str_pad($_SESSION['user']['id'] ?? 0, 4, '0', STR_PAD_LEFT); ?>
                </div>
            </div>
        </div>
    </div>

    <button onclick="window.print()" class="no-print mt-10 px-8 py-3 bg-[#7b604c] text-white rounded-full shadow-lg transition-all font-bold hover:scale-105 active:scale-95 flex items-center gap-2">
        <span>🖨️</span> Print Kartu Member
    </button>
</body>

</html>