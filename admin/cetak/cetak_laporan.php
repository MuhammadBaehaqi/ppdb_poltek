<?php
require('../../includes/koneksi.php');
require_once('../../libs/fpdf186/fpdf.php'); // pastikan sudah download FPDF (https://fpdf.org)

$bulan = $_GET['bulan'] ?? date('m');
$tahun = $_GET['tahun'] ?? date('Y');

$query = "SELECT * FROM tb_pendaftaran WHERE MONTH(tanggal_daftar) = '$bulan' AND YEAR(tanggal_daftar) = '$tahun'";
$result = mysqli_query($conn, $query);

$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Laporan Pendaftaran Bulan ' . date('F', mktime(0, 0, 0, $bulan, 10)) . " $tahun", 0, 1, 'C');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 10, 'No', 1);
$pdf->Cell(40, 10, 'NIK', 1);
$pdf->Cell(60, 10, 'Nama Lengkap', 1);
$pdf->Cell(40, 10, 'Tanggal Daftar', 1);
$pdf->Cell(40, 10, 'Status', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 10);
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $pdf->Cell(10, 10, $no++, 1);
    $pdf->Cell(40, 10, $row['nik'], 1);
    $pdf->Cell(60, 10, $row['nama_lengkap'], 1);
    $pdf->Cell(40, 10, $row['tanggal_daftar'], 1);
    $pdf->Cell(40, 10, $row['status_pendaftaran'], 1);
    $pdf->Ln();
}

$pdf->Output();
