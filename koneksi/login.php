<?php
session_start();
include "config.php";

// Pastikan respon selalu JSON
header('Content-Type: application/json');

function login($username, $password) {
    global $SUPABASE_URL, $SUPABASE_KEY;

    $url = $SUPABASE_URL . "/rest/v1/users?username=eq." . urlencode($username);
    $headers = ["apikey: $SUPABASE_KEY", "Authorization: Bearer $SUPABASE_KEY", "Content-Type: application/json"];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    $data = json_decode($response, true);
    curl_close($ch);

    if (empty($data)) {
        echo json_encode(["status" => "error", "message" => "Username tidak ditemukan"]);
        return;
    }

    $user = $data[0];

    if (password_verify($password, $user['password'])) {
        $_SESSION['user'] = ["id" => $user['id'], "username" => $user['username'], "role" => $user['role'], "nama_lengkap" => $user['nama_lengkap'], "email" => $user['email']];
        echo json_encode(["status" => "success", "message" => "Login berhasil!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Password salah"]);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    login($_POST['username'], $_POST['password']);
}
?>