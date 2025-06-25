<?php
include '../config/db.php';

$result = $conn->query("SELECT * FROM produk ORDER BY id DESC");

$produk = [];
while ($row = $result->fetch_assoc()) {
  $produk[] = $row;
}

header('Content-Type: application/json');
echo json_encode($produk);
?>
