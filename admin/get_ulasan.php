<?php
include '../config/db.php';

$res = $conn->query("SELECT * FROM ulasan ORDER BY created_at DESC");
$data = [];

while ($row = $res->fetch_assoc()) {
  $data[] = $row; // pastikan kolom: nama, komentar, rating
}

header('Content-Type: application/json');
echo json_encode($data);
?>
