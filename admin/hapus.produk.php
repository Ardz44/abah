<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
  $id = $_POST['id'];

  // Ambil nama file gambar untuk dihapus dari folder
  $query = $conn->prepare("SELECT gambar FROM produk WHERE id = ?");
  $query->bind_param("i", $id);
  $query->execute();
  $result = $query->get_result();
  $produk = $result->fetch_assoc();

  if ($produk && file_exists("../image/" . $produk['gambar'])) {
    unlink("../image/" . $produk['gambar']); // Hapus file
  }

  // Hapus dari database
  $stmt = $conn->prepare("DELETE FROM produk WHERE id = ?");
  $stmt->bind_param("i", $id);
  $stmt->execute();

  echo "<script>alert('Produk berhasil dihapus!'); window.location.href='produk.html';</script>";
} else {
  echo "<script>alert('Permintaan tidak valid'); history.back();</script>";
}
?>
