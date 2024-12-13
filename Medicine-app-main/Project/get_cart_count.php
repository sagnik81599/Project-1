<?php
session_start();
include("php/config.php");

if (!isset($_SESSION['valid']) || !isset($_SESSION['id'])) {
    header('Content-Type: application/json');
    echo json_encode(['count' => 0]);
    exit();
}

$user_id = $_SESSION['id'];
$cart_count_sql = "SELECT COUNT(*) as count FROM cart WHERE user_id = ?";
$cart_count_stmt = $con->prepare($cart_count_sql);
$cart_count_stmt->bind_param("i", $user_id);
$cart_count_stmt->execute();
$cart_count_result = $cart_count_stmt->get_result();

$count = 0;
if ($cart_count_result && $cart_row = $cart_count_result->fetch_assoc()) {
    $count = $cart_row['count'];
}

$cart_count_stmt->close();

header('Content-Type: application/json');
echo json_encode(['count' => $count]);
?>
