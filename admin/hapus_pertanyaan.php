<?php
include '../koneksi.php';
session_start();
if ($_SESSION['role'] != 'admin') header("Location: ../login.php");

$id = $_GET['id'];
$conn->query("DELETE FROM pertanyaan WHERE id = $id");

header("Location: kelola_pertanyaan.php");
