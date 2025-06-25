<?php
include '../config/db.php';

$status = $_GET['status'] ?? '';
$from = $_GET['from'] ?? '';
$to = $_GET['to'] ?? '';

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=laporan_terfilter.csv');

$output = fopen("php://output", "w");
fputcsv($output, ['Order ID', 'Username', 'Total', 'Status', 'Tanggal']);

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

while ($row = $res->fetch_assoc()) {
  fputcsv($output, [$row['order_id'], $row['username'], $row['total'], $row['status'], $row['created_at']]);
}

fclose($output);
?>
