<?php include 'sidebar.php'; ?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pendaftaran | Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .content {
            margin-left: 260px;
            padding: 20px;
        }

        @media (max-width: 768px) {
            .content {
                margin-left: 0;
            }
        }

        .card {
            border: none;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
        }

        .table th {
            background-color: #0d6efd;
            color: #fff;
        }
    </style>
</head>

<body>

    <!-- Konten Utama -->
    <div class="content">
        <div class="container-fluid">
            <h3 class="fw-bold mb-4"><i class="bi bi-person-lines-fill me-2"></i>Data Pendaftaran</h3>

            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <button class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>Tambah Data</button>
                        </div>
                        <div class="input-group" style="width: 300px;">
                            <input type="text" class="form-control" placeholder="Cari nama santri...">
                            <button class="btn btn-outline-secondary"><i class="bi bi-search"></i></button>
                        </div>
                    </div>

                    <table class="table table-bordered table-striped align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>Jenis Kelamin</th>
                                <th>Asal Sekolah</th>
                                <th>Tanggal Daftar</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Ahmad Zaky</td>
                                <td>Laki-laki</td>
                                <td>MTS Al Muflihin</td>
                                <td>2025-10-27</td>
                                <td><span class="badge bg-success">Diterima</span></td>
                                <td>
                                    <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                    <button class="btn btn-sm btn-info text-white"><i class="bi bi-eye"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Siti Rahma</td>
                                <td>Perempuan</td>
                                <td>MTSN 2 Cirebon</td>
                                <td>2025-10-28</td>
                                <td><span class="badge bg-warning text-dark">Menunggu</span></td>
                                <td>
                                    <button class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                    <button class="btn btn-sm btn-info text-white"><i class="bi bi-eye"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end">
                            <li class="page-item disabled"><a class="page-link">Previous</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>