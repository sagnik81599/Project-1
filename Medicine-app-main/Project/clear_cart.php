<?php
session_start();
include("php/config.php");

if (!isset($_SESSION['valid']) || !isset($_SESSION['id'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['id'];
    
    // Delete all items from cart for this user
    $clear_sql = "DELETE FROM cart WHERE user_id = ?";
    $clear_stmt = $con->prepare($clear_sql);
    $clear_stmt->bind_param("i", $user_id);
    
    $success = $clear_stmt->execute();
    $clear_stmt->close();
    
    header('Content-Type: application/json');
    if ($success) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to clear cart']);
    }
    exit();
}

header('Content-Type: application/json');
echo json_encode(['success' => false, 'message' => 'Invalid request method']);
?>
