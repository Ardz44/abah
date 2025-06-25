<?php
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $role = 'user';

  $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $username, $password, $role);

  if ($stmt->execute()) {
    echo "<script>alert('Registrasi berhasil!'); window.location.href='login.html';</script>";
  } else {
    echo "<script>alert('Registrasi gagal!'); history.back();</script>";
  }
}
?>
