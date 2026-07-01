<?php
session_start();
include "config.php";

header('Content-Type: application/json');

$nama_lengkap = $_POST['nama_lengkap'] ?? '';
$email = $_POST['email'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

if (!$nama_lengkap || !$email || !$username || !$password) {
    echo json_encode(["status" => "error", "message" => "Semua field wajib diisi"]);
    exit;
}

if ($password !== $confirm_password) {
    echo json_encode(["status" => "error", "message" => "Password tidak sama"]);
    exit;
}

// Cek Username
$checkUrl = $SUPABASE_URL . "/rest/v1/users?username=eq." . urlencode($username);
$headers = ["apikey: $SUPABASE_KEY", "Authorization: Bearer $SUPABASE_KEY", "Content-Type: application/json"];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $checkUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$response = curl_exec($ch);
$data = json_decode($response, true);
curl_close($ch);

if (!empty($data)) {
    echo json_encode(["status" => "error", "message" => "Username sudah digunakan"]);
    exit;
}

// Insert User
$insertUrl = $SUPABASE_URL . "/rest/v1/users";
$newUser = [
    "nama_lengkap" => $nama_lengkap,
    "email" => $email,
    "username" => $username,
    "password" => password_hash($password, PASSWORD_DEFAULT),
    "role" => "user"
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $insertUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($newUser));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$response = curl_exec($ch);
curl_close($ch);

echo json_encode(["status" => "success", "message" => "Pendaftaran berhasil!"]);
?>  