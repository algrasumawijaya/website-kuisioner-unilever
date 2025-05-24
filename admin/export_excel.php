<?php
include '../koneksi.php';

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=jawaban_kuisioner.xls");

echo "<table border='1'>
    <tr>
        <th>Nama</th><th>Usia</th><th>Jenis Kelamin</th><th>Pekerjaan</th>
        <th>Pertanyaan</th><th>Jenis</th><th>Jawaban</th>
    </tr>";

$query = $conn->query("
    SELECT 
        biodata.nama, biodata.usia, biodata.jenis_kelamin, biodata.pekerjaan,
        pertanyaan.isi_pertanyaan, pertanyaan.jenis,
        jawaban_kuisioner.jawaban
    FROM jawaban_kuisioner
    JOIN users ON jawaban_kuisioner.id_user = users.id
    JOIN biodata ON users.id = biodata.id_user
    JOIN pertanyaan ON jawaban_kuisioner.id_pertanyaan = pertanyaan.id
    ORDER BY users.id, pertanyaan.id
");

while ($row = $query->fetch_assoc()) {
    echo "<tr>
        <td>{$row['nama']}</td>
        <td>{$row['usia']}</td>
        <td>{$row['jenis_kelamin']}</td>
        <td>{$row['pekerjaan']}</td>
        <td>{$row['isi_pertanyaan']}</td>
        <td>{$row['jenis']}</td>
        <td>{$row['jawaban']}</td>
    </tr>";
}
echo "</table>";
