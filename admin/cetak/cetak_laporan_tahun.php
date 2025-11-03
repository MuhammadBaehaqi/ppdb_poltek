<?php
require('../../includes/koneksi.php');
require_once('../../libs/fpdf186/fpdf.php');

$tahun = $_GET['tahun'] ?? date('Y');

// Ambil data dari database
$query = "SELECT MONTH(tanggal_daftar) AS bulan, COUNT(*) AS jumlah 
          FROM tb_pendaftaran 
          WHERE YEAR(tanggal_daftar) = '$tahun'
          GROUP BY MONTH(tanggal_daftar)";
$result = mysqli_query($conn, $query);

// Siapkan array 12 bulan default
$dataBulan = [];
for ($i = 1; $i <= 12; $i++) {
    $dataBulan[$i] = 0; // default 0
}

// Isi jumlah berdasarkan hasil query
while ($row = mysqli_fetch_assoc($result)) {
    $bulan = (int)$row['bulan'];
    $dataBulan[$bulan] = (int)$row['jumlah'];
}

// Buat PDF
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

// Judul
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, "Laporan Pendaftaran Tahun $tahun", 0, 1, 'C');
$pdf->Ln(5);

// Header tabel
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(20, 10, 'No', 1, 0, 'C');
$pdf->Cell(100, 10, 'Bulan', 1, 0, 'C');
$pdf->Cell(50, 10, 'Jumlah Pendaftar', 1, 1, 'C');

// Isi tabel
$pdf->SetFont('Arial', '', 11);
$no = 1;
$total = 0;

for ($i = 1; $i <= 12; $i++) {
    $bulanNama = date('F', mktime(0, 0, 0, $i, 10)); // January–December
    $jumlah = $dataBulan[$i];
    $pdf->Cell(20, 10, $no++, 1, 0, 'C');
    $pdf->Cell(100, 10, $bulanNama, 1, 0, 'L');
    $pdf->Cell(50, 10, $jumlah, 1, 1, 'C');
    $total += $jumlah;
}

// Total keseluruhan
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(120, 10, 'Total Pendaftar', 1);
$pdf->Cell(50, 10, $total, 1, 1, 'C');

// Output file
$pdf->Output("I", "Laporan_Pendaftaran_Tahun_$tahun.pdf");
?>
