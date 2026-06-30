<?php


session_start();
include "config.php";

$nama_lengkap = $_POST['nama_lengkap'] ?? '';
$email = $_POST['email'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

if (!$nama_lengkap || !$email || !$username || !$password) {
    echo "❌ Semua field wajib diisi";
    exit;
}

if ($password !== $confirm_password) {
    echo "❌ Password tidak sama";
    exit;
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$checkUrl = $SUPABASE_URL . "/rest/v1/users?username=eq." . urlencode($username);

$headers = [
    "apikey: $SUPABASE_KEY",
    "Authorization: Bearer $SUPABASE_KEY",
    "Content-Type: application/json"
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $checkUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

if (count($data) > 0) {
    echo "❌ Username sudah digunakan";
    exit;
}

$insertUrl = $SUPABASE_URL . "/rest/v1/users";

$newUser = [
    "nama_lengkap" => $nama_lengkap,
    "email" => $email,
    "username" => $username,
    "password" => $hashed_password,
    "role" => "user"
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $insertUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($newUser));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo "Error: " . curl_error($ch);
    curl_close($ch);
    exit;
}

curl_close($ch);

$_SESSION['user'] = [
    "username" => $username
];

header("Location: ../index.php");
exit;