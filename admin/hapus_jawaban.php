<?php
include '../koneksi.php';

if (isset($_GET['id_user'])) {
    $id_user = $_GET['id_user'];

    // Hapus jawaban kuisioner
    $conn->query("DELETE FROM jawaban_kuisioner WHERE id_user = $id_user");

    // Optional: juga hapus biodatanya
    $conn->query("DELETE FROM biodata WHERE id_user = $id_user");

    header("Location: kelola_jawaban.php");
}
