<?php
include '../config/db.php';

$status = $_GET['status'] ?? '';
$from = $_GET['from'] ?? '';
$to = $_GET['to'] ?? '';

$sql = "SELECT * FROM orders WHERE 1=1";

if ($status !== '') {
  $sql .= " AND status = '" . $conn->real_escape_string($status) . "'";
}

if ($from !== '') {
  $sql .= " AND DATE(created_at) >= '" . $conn->real_escape_string($from) . "'";
}

if ($to !== '') {
  $sql .= " AND DATE(created_at) <= '" . $conn->real_escape_string($to) . "'";
}

$sql .= " ORDER BY created_at DESC";

$res = $conn->query($sql);
$data = [];

while ($row = $res->fetch_assoc()) {
  $data[] = $row;
}

echo json_encode($data);
?>
