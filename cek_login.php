<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'includes/koneksi.php';

// Pastikan form dikirim via POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit();
}

$username = trim($_POST['username']);
$password = $_POST['password'];

// Validasi input kosong
if ($username === '' || $password === '') {
    echo "<script>alert('Username dan password wajib diisi!');window.history.back();</script>";
    exit();
}

/* ===========================================================
   1️⃣ CEK LOGIN UNTUK ADMIN
=========================================================== */
$stmt = mysqli_prepare($conn, "SELECT id, nama_admin, username, email, password, role 
                               FROM admin WHERE username = ? LIMIT 1");
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) === 1) {
    mysqli_stmt_bind_result($stmt, $id, $nama_admin, $db_username, $email, $db_password, $role);
    mysqli_stmt_fetch($stmt);

    // Cek password admin
    if (password_verify($password, $db_password)) {
        $_SESSION['admin_id'] = $id;
        $_SESSION['nama_admin'] = $nama_admin;
        $_SESSION['username'] = $db_username;
        $_SESSION['role'] = $role;
        $_SESSION['last_activity'] = time();
        header("Location: admin/dashboard_admin.php");
        exit();
    } else {
        echo "<script>alert('Password salah!');window.history.back();</script>";
        exit();
    }
}

/* ===========================================================
   2️⃣ CEK LOGIN UNTUK MAHASISWA (tb_user)
=========================================================== */
$stmt2 = mysqli_prepare($conn, "SELECT id_user, nama_lengkap, username, password, role, status_akun 
                                FROM tb_user WHERE username = ? LIMIT 1");
mysqli_stmt_bind_param($stmt2, "s", $username);
mysqli_stmt_execute($stmt2);
mysqli_stmt_store_result($stmt2);

if (mysqli_stmt_num_rows($stmt2) === 1) {
    mysqli_stmt_bind_result($stmt2, $id_user, $nama_lengkap, $db_username, $db_password, $role, $status_akun);
    mysqli_stmt_fetch($stmt2);

    // Cek status akun
    if ($status_akun !== 'aktif') {
        echo "<script>alert('Akun Anda belum aktif. Tunggu verifikasi admin.');window.location='login.php';</script>";
        exit();
    }

    // Cek password mahasiswa (bisa hash atau plain text)
    $isValid = false;
    if (password_verify($password, $db_password)) {
        $isValid = true; // jika password di-hash
    } elseif ($password === $db_password) {
        $isValid = true; // jika password masih plain text (fallback lama)
    }

    if (!$isValid) {
        echo "<script>alert('Password salah!');window.history.back();</script>";
        exit();
    }

    // Login mahasiswa sukses
    $_SESSION['id_user'] = $id_user;
    $_SESSION['nama_lengkap'] = $nama_lengkap;
    $_SESSION['username'] = $db_username;
    $_SESSION['role'] = $role;

    header("Location: user/dashboard_user.php");
    exit();
}

/* ===========================================================
   3️⃣ USER TIDAK DITEMUKAN
=========================================================== */
echo "<script>alert('Username tidak ditemukan! Pastikan Anda sudah mendaftar.');window.history.back();</script>";
exit();
?>
