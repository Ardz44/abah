<?php
// Handle webhook dari Midtrans
include 'config/db.php';
require_once 'midtrans/Midtrans.php';

\Midtrans\Config::$serverKey = 'YOUR_SERVER_KEY';
\Midtrans\Config::$isProduction = false;

$json = file_get_contents("php://input");
$notif = json_decode($json);

$transaction_status = $notif->transaction_status;
$order_id = $notif->order_id;

$status_map = [
  'capture' => 'paid',
  'settlement' => 'paid',
  'pending' => 'pending',
  'deny' => 'failed',
  'expire' => 'expired',
  'cancel' => 'cancelled'
];

$status = isset($status_map[$transaction_status]) ? $status_map[$transaction_status] : 'unknown';

$stmt = $conn->prepare("UPDATE orders SET status = ? WHERE order_id = ?");
$stmt->bind_param("ss", $status, $order_id);
$stmt->execute();

?>
