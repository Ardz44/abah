<?php
include '../config/db.php';

$nama = $_POST['nama'];
$komentar = $_POST['komentar'];
$rating = $_POST['rating'] ?? 5;

$stmt = $conn->prepare("INSERT INTO ulasan (nama, komentar, rating) VALUES (?, ?, ?)");
$stmt->bind_param("ssi", $nama, $komentar, $rating);

if ($stmt->execute()) {
  echo "<script>
    alert('Ulasan berhasil dikirim!');
    window.location.href = 'index.html#review';
  </script>";
} else {
  echo "<script>
    alert('Gagal mengirim ulasan.'); 
    history.back();
  </script>";
}
?>
