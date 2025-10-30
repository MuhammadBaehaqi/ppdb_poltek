<?php
// sidebar_user.php

// Mulai session jika belum
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<style>
    .sidebar {
        width: 240px;
        background-color: #212529;
        color: white;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding-top: 20px;
        position: fixed;
        height: 100vh;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    }

    .sidebar img.logo {
        width: 80px;
        height: 80px;
        margin-bottom: 10px;
        border-radius: 50%;
    }

    .sidebar .brand {
        font-size: 0.95rem;
        text-align: center;
        font-weight: bold;
        line-height: 1.3;
        padding: 0 15px 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .menu {
        padding: 20px;
        width: 100%;
    }

    .menu a {
        display: block;
        color: white;
        text-decoration: none;
        padding: 12px 15px;
        margin-bottom: 10px;
        border-radius: 6px;
        transition: background 0.3s;
    }

    .menu a:hover,
    .menu a.active {
        background-color: #393a3a;
    }
</style>

<div class="sidebar">
    <img src="../img/logo.png" alt="Logo Poltek" class="logo">
    <div class="brand">
        POLITEKNIK<br>MITRA KARYA MANDIRI
    </div>

    <div class="menu">
        <a href="dashboard_user.php"
            class="<?= basename($_SERVER['PHP_SELF']) == 'dashboard_user.php' ? 'active' : '' ?>">🏠 Dashboard</a>
        <a href="pengaturan.php" class="<?= basename($_SERVER['PHP_SELF']) == 'pengaturan.php' ? 'active' : '' ?>">⚙️
            Pengaturan</a>
        <a href="../logout.php">🚪 Logout</a>
    </div>
</div>