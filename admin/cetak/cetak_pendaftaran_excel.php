<?php
include '../../includes/koneksi.php';
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Laporan_Pendaftaran.xls");

echo "<table border='1'>
<tr>
    <th>No</th>
    <th>Nama Lengkap</th>
    <th>NIK</th>
    <th>NISN</th>
    <th>Email</th>
    <th>Program Studi</th>
    <th>Status</th>
    <th>Tanggal Daftar</th>
</tr>";

$no = 1;
$query = mysqli_query($conn, "SELECT * FROM tb_pendaftaran ORDER BY id_pendaftaran DESC");
while ($row = mysqli_fetch_assoc($query)) {
    echo "<tr>
        <td>{$no}</td>
        <td>{$row['nama_lengkap']}</td>
        <td>{$row['nik']}</td>
        <td>{$row['nisn']}</td>
        <td>{$row['email']}</td>
        <td>{$row['program_studi']}</td>
        <td>{$row['status_pendaftaran']}</td>
        <td>" . date('d-m-Y', strtotime($row['tanggal_daftar'])) . "</td>
    </tr>";
    $no++;
}
echo "</table>";
?>
