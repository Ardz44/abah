<?php
session_start();
include '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();
  $user = $result->fetch_assoc();

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    // Redirect berdasarkan role
    if ($user['role'] == 'admin') {
      echo "<script>
        localStorage.setItem('activeUser', '{$user['username']}');
        localStorage.setItem('activeRole', 'admin');
        window.location.href = '../admin/admin.html';
      </script>";
    } else {
      echo "<script>
        localStorage.setItem('activeUser', '{$user['username']}');
        localStorage.setItem('activeRole', 'user');
        window.location.href = 'index.html';
      </script>";
    }
  } else {
    echo "<script>alert('Username atau password salah!'); history.back();</script>";
  }
}
?>
