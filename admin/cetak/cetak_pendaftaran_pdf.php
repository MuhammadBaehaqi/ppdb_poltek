<?php
require('../../includes/koneksi.php');
require_once('../../libs/fpdf186/fpdf.php'); // pastikan sudah download FPDF (https://fpdf.org)

$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'LAPORAN DATA PENDAFTARAN MAHASISWA', 0, 1, 'C');

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(10, 10, 'No', 1);
$pdf->Cell(40, 10, 'Nama Lengkap', 1);
$pdf->Cell(30, 10, 'NIK', 1);
$pdf->Cell(30, 10, 'NISN', 1);
$pdf->Cell(40, 10, 'Email', 1);
$pdf->Cell(40, 10, 'Program Studi', 1);
$pdf->Cell(30, 10, 'Status', 1);
$pdf->Cell(40, 10, 'Tanggal Daftar', 1);
$pdf->Ln();

$pdf->SetFont('Arial', '', 10);
$no = 1;
$query = mysqli_query($conn, "SELECT * FROM tb_pendaftaran ORDER BY id_pendaftaran DESC");
while ($row = mysqli_fetch_assoc($query)) {
    $pdf->Cell(10, 8, $no++, 1);
    $pdf->Cell(40, 8, $row['nama_lengkap'], 1);
    $pdf->Cell(30, 8, $row['nik'], 1);
    $pdf->Cell(30, 8, $row['nisn'], 1);
    $pdf->Cell(40, 8, $row['email'], 1);
    $pdf->Cell(40, 8, $row['program_studi'], 1);
    $pdf->Cell(30, 8, $row['status_pendaftaran'], 1);
    $pdf->Cell(40, 8, date('d-m-Y', strtotime($row['tanggal_daftar'])), 1);
    $pdf->Ln();
}

$pdf->Output('I', 'Laporan_Pendaftaran.pdf');
?>
