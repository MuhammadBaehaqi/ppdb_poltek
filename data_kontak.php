<?php include 'sidebar_admin.php'; ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kontak | Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        /* Pastikan konten tidak ketutup navbar & sidebar */
        .main-content {
            margin-left: 250px; /* sesuai lebar sidebar */
            padding: 90px 20px 20px 20px; /* tambahkan padding atas biar gak ketimpa navbar */
            transition: margin-left 0.3s ease;
        }

        /* Saat layar kecil (sidebar jadi overlay) */
        @media (max-width: 992px) {
            .main-content {
                margin-left: 0;
                padding-top: 100px; /* tetap kasih jarak atas */
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

<!-- Konten Utama -->
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
                                    <th>Subjek</th>
                                    <th>Pesan</th>
                                    <th>Tanggal</th>
                                    <th style="width: 120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Contoh Data -->
                                <tr>
                                    <td class="text-center">1</td>
                                    <td>Rizky Pratama</td>
                                    <td>
                                        <a href="#" class="text-decoration-none text-primary">
                                            <i class="bi bi-envelope-at-fill me-1"></i>rizky@gmail.com
                                        </a>
                                    </td>
                                    <td>Info Pendaftaran</td>
                                    <td>Saya ingin bertanya tentang jadwal penerimaan mahasiswa baru.</td>
                                    <td class="text-center">28-10-2025 09:32</td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-sm btn-success me-1" title="Balas Email">
                                            <i class="bi bi-reply-fill"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-danger" title="Hapus Pesan">
                                            <i class="bi bi-trash-fill"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">2</td>
                                    <td>Dewi Lestari</td>
                                    <td>
                                        <a href="#" class="text-decoration-none text-primary">
                                            <i class="bi bi-envelope-at-fill me-1"></i>dewi@gmail.com
                                        </a>
                                    </td>
                                    <td>Kerja Sama</td>
                                    <td>Apakah kampus membuka peluang kerja sama dengan perusahaan kami?</td>
                                    <td class="text-center">27-10-2025 14:20</td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-sm btn-success me-1" title="Balas Email">
                                            <i class="bi bi-reply-fill"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-danger" title="Hapus Pesan">
                                            <i class="bi bi-trash-fill"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center">3</td>
                                    <td>Andi Kurniawan</td>
                                    <td>
                                        <a href="#" class="text-decoration-none text-primary">
                                            <i class="bi bi-envelope-at-fill me-1"></i>andi.k@gmail.com
                                        </a>
                                    </td>
                                    <td>Permintaan Brosur</td>
                                    <td>Boleh minta brosur lengkap tentang jurusan yang tersedia?</td>
                                    <td class="text-center">26-10-2025 11:47</td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-sm btn-success me-1" title="Balas Email">
                                            <i class="bi bi-reply-fill"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-danger" title="Hapus Pesan">
                                            <i class="bi bi-trash-fill"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
