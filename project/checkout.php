<?php
session_start();
include '../config/db.php';
require_once 'midtrans/Midtrans.php';

\Midtrans\Config::$serverKey = 'YOUR_SERVER_KEY';
\Midtrans\Config::$isProduction = false;
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;

$data = json_decode(file_get_contents("php://input"), true);

$order_id = 'ORDER-' . rand(1000, 9999) . time();
$username = $data['username'];
$total = $data['total'];

$params = [
  'transaction_details' => [
    'order_id' => $order_id,
    'gross_amount' => $total
  ],
  'customer_details' => [
    'first_name' => $username
  ]
];

try {
  $snapToken = \Midtrans\Snap::getSnapToken($params);

  // Simpan ke database
  $stmt = $conn->prepare("INSERT INTO orders (order_id, username, total, status) VALUES (?, ?, ?, 'pending')");
  $stmt->bind_param("ssd", $order_id, $username, $total);
  $stmt->execute();

  echo json_encode(['snapToken' => $snapToken]);
} catch (Exception $e) {
  echo json_encode(['error' => $e->getMessage()]);
  echo json_encode(['snapToken' => $snapToken, 'order_id' => $order_id]);

}

// Simpan item ke order_items
foreach ($data['items'] as $item) {
  $itemName = $item['item'];
  $itemPrice = $item['price'];
  $qty = $item['qty'] ?? 1;

  $stmtItem = $conn->prepare("INSERT INTO order_items (order_id, item_name, price, quantity) VALUES (?, ?, ?, ?)");
  $stmtItem->bind_param("ssdi", $order_id, $itemName, $itemPrice, $qty);
  $stmtItem->execute();
}

?>
