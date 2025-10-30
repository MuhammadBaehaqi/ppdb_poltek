<?php
session_start();
$_SESSION['kontak_diklik'] = true; // tandai sudah diklik

include 'koneksi.php';
// tandai semua pesan sudah dibaca
mysqli_query($conn, "UPDATE kontak SET status_baca = 'sudah baca' WHERE status_baca = 'belum baca'");

// ambil data kontak
$query = mysqli_query($conn, "SELECT * FROM kontak ORDER BY id_pesan DESC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kontak | Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="img/logo_mkm.png" type="image/x-icon">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .main-content {
            margin-left: 250px;
            padding: 30px;
            transition: margin-left 0.3s ease;
        }

        @media (max-width: 992px) {
            .main-content {
                margin-left: 0;
                padding-top: 100px;
            }
        }

        .table-responsive {
            overflow-x: auto;
        }

        .card {
            border-radius: 12px;
            border: none;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        }

        .table thead th {
            vertical-align: middle;
            white-space: nowrap;
            background-color: #0d6efd;
            color: white;
        }

        .table td {
            vertical-align: middle;
        }

        .btn {
            border-radius: 8px;
        }
    </style>
</head>

<body>
    <!-- ✅ Sidebar & Navbar dimasukkan di sini -->
    <?php include 'sidebar_admin.php'; ?>
    <div class="main-content">
        <div class="container-fluid">
            <div class="p-3">
                <h2 class="text-black mb-4">
                    <i class="bi bi-envelope-fill me-2"></i> Pesan Kontak
                </h2>

                <div class="card shadow border-0">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="text-center">
                                    <tr>
                                        <th style="width: 50px;">No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Nomor WhatsApp</th>
                                        <th>Pesan</th>
                                        <th>Tanggal</th>
                                        <th style="width: 160px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    if (mysqli_num_rows($query) > 0) {
                                        while ($row = mysqli_fetch_assoc($query)) {
                                            echo "
                                        <tr>
                                            <td class='text-center'>{$no}</td>
                                            <td>{$row['nama']}</td>
                                            <td>{$row['email']}</td>
                                            <td>{$row['nomor_wa']}</td>
                                            <td>{$row['pesan']}</td>
                                            <td class='text-center'>" . date('d-m-Y H:i', strtotime($row['tanggal'])) . "</td>
                                            <td class='text-center'>
                                                <!-- Tombol WA -->
                                                <a href='https://wa.me/{$row['nomor_wa']}' target='_blank' class='btn btn-sm btn-success me-1' title='Balas via WhatsApp'>
                                                    <i class='bi bi-whatsapp'></i>
                                                </a>

                                                <!-- Tombol Email -->
                                                <a href='mailto:{$row['email']}' class='btn btn-sm btn-primary me-1' title='Balas via Email'>
                                                    <i class='bi bi-envelope-fill'></i>
                                                </a>

                                                <!-- Tombol Hapus -->
                                                <a href='hapus_kontak.php?id={$row['id_pesan']}' class='btn btn-sm btn-danger' title='Hapus Pesan' onclick='return confirm(\"Yakin ingin menghapus pesan ini?\")'>
                                                    <i class='bi bi-trash-fill'></i>
                                                </a>
                                            </td>
                                        </tr>
                                        ";
                                            $no++;
                                        }
                                    } else {
                                        echo "
                                    <tr>
                                        <td colspan='7' class='text-center text-muted'>Belum ada pesan masuk</td>
                                    </tr>
                                    ";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js'></script>
</body>

</html>