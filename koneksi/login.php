<?php
session_start();

include "config.php";

function login($username, $password) {
    global $SUPABASE_URL, $SUPABASE_KEY;

    $url = $SUPABASE_URL . "/rest/v1/users?username=eq." . urlencode($username);

    $headers = [
        "apikey: $SUPABASE_KEY",
        "Authorization: Bearer $SUPABASE_KEY",
        "Content-Type: application/json"
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo "Error: " . curl_error($ch);
        curl_close($ch);
        return;
    }

    curl_close($ch);

    $data = json_decode($response, true);

    if (count($data) == 0) {
        echo "❌ Username tidak ditemukan";
        return;
    }

    $user = $data[0];

    if ($user['password'] === $password) {
        $_SESSION['user'] = [
            "id" => $user['id'],
            "username" => $user['username'],
            "role" => $user['role']
        ];

        echo "✅ Login berhasil";
        header("Location: ../index.php");
        exit;
    } else {
        echo "❌ Password salah";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    login($username, $password);
}
?>