<?php
require_once "config.php";
$id = $_POST['id'];
$sql = "DELETE FROM data_jabatan WHERE id = '$id'";
mysqli_query($link, $sql);
echo "<script>alert('Berhasil Hapus Jabatan'); window.location.href='data_jabatan-index.php'</script>";
