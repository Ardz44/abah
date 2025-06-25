<?php
require 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;

include '../config/db.php';

$order_id = $_GET['order_id'] ?? '';
if (!$order_id) die("Order ID tidak ditemukan");

$stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ?");
$stmt->bind_param("s", $order_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();
if (!$order) die("Data tidak ditemukan");

$html = '
  <style>
    body { font-family: Arial, sans-serif; font-size: 14px; }
    h2 { text-align: center; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    td, th { border: 1px solid #333; padding: 8px; text-align: left; }
    .logo { text-align: center; margin-bottom: 10px; }
    .footer { text-align: center; margin-top: 30px; font-style: italic; }
  </style>

  <div class="logo">
    <img src="image/Bah-Sipit.png" width="100" />
  </div>

  <h2>INVOICE PEMBAYARAN</h2>

  <table>
    <tr>
      <th>Order ID</th><td>' . $order['order_id'] . '</td>
    </tr>
    <tr>
      <th>Username</th><td>' . $order['username'] . '</td>
    </tr>
    <tr>
      <th>Status</th><td>' . strtoupper($order['status']) . '</td>
    </tr>
    <tr>
      <th>Total</th><td>$' . number_format($order['total'], 2) . '</td>
    </tr>
    <tr>
      <th>Tanggal</th><td>' . $order['created_at'] . '</td>
    </tr>
  </table>

  <div class="footer">
    Terima kasih telah berbelanja di <strong>Kedai Kopi BahSipit</strong> ☕<br>
    Harimu pasti lebih hangat.
  </div>
';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A5', 'portrait');
$dompdf->render();
$dompdf->stream("Invoice_{$order_id}.pdf", ["Attachment" => false]);
?>
