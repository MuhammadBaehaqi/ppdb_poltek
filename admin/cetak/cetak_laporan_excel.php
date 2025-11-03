<?php
include '../../includes/koneksi.php';

// Set header agar browser mengunduh file Excel
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_pendaftaran_" . date('Ymd_His') . ".xls");
header("Pragma: no-cache");
header("Expires: 0");

// Deteksi jenis laporan
if (isset($_GET['bulan']) && isset($_GET['tahun'])) {
    $bulan = $_GET['bulan'];
    $tahun = $_GET['tahun'];
    $judul = "Laporan Pendaftaran Bulan " . date('F', mktime(0, 0, 0, $bulan, 10)) . " $tahun";
    $query = "SELECT * FROM tb_pendaftaran WHERE MONTH(tanggal_daftar)='$bulan' AND YEAR(tanggal_daftar)='$tahun'";
} elseif (isset($_GET['mingguan'])) {
    $mulai = $_GET['mulai'];
    $selesai = $_GET['selesai'];
    $judul = "Laporan Pendaftaran Mingguan ($mulai s/d $selesai)";
    $query = "SELECT * FROM tb_pendaftaran WHERE DATE(tanggal_daftar) BETWEEN '$mulai' AND '$selesai'";
} elseif (isset($_GET['tahun'])) {
    $tahun = $_GET['tahun'];
    $judul = "Laporan Pendaftaran Tahun $tahun";
    $query = "SELECT * FROM tb_pendaftaran WHERE YEAR(tanggal_daftar)='$tahun'";
} else {
    echo "Parameter laporan tidak valid!";
    exit;
}

$result = mysqli_query($conn, $query);
?>

<h3 style="text-align:center;"><?= $judul ?></h3>
<table border="1" cellspacing="0" cellpadding="5" width="100%">
    <thead style="background-color:#0d6efd; color:white;">
        <tr>
            <th>No</th>
            <th>Nama Lengkap</th>
            <th>NIK</th>
            <th>Tanggal Daftar</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td>{$no}</td>
            <td>{$row['nama_lengkap']}</td>
            <td style=\"mso-number-format:'\\@';\">'{$row['nik']}</td>
            <td>" . date('d-m-Y', strtotime($row['tanggal_daftar'])) . "</td>
            <td>{$row['status_pendaftaran']}</td>
          </tr>";
    $no++;
}

        } else {
            echo "<tr><td colspan='5' align='center'>Tidak ada data.</td></tr>";
        }
        ?>
    </tbody>
</table>
