<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nama = $_POST['nama'];
  $harga = $_POST['harga'];
  $deskripsi = $_POST['deskripsi'];
  $gambar = $_FILES['gambar']['name'];
  $target = '../image/' . basename($gambar);

  if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) {
    $stmt = $conn->prepare("INSERT INTO produk (nama, harga, deskripsi, gambar) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdss", $nama, $harga, $deskripsi, $gambar);
    if ($stmt->execute()) {
      echo "<script>alert('Produk berhasil diupload'); window.location.href='uploadproduk.html';</script>";
    } else {
      echo "<script>alert('Gagal upload produk'); history.back();</script>";
    }
  } else {
    echo "<script>alert('Upload file gagal'); history.back();</script>";
  }
}
?>
