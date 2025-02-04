<?php
session_start();
include("php/config.php");

if (!isset($_SESSION['valid']) || !isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['medicine_id'])) {
    $user_id = $_SESSION['id'];
    $medicine_id = $_POST['medicine_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    
    // Check if item already exists in cart
    $check_sql = "SELECT id, quantity FROM cart WHERE user_id = ? AND medicine_id = ?";
    $check_stmt = $con->prepare($check_sql);
    $check_stmt->bind_param("ii", $user_id, $medicine_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Item exists, update quantity
        $row = $result->fetch_assoc();
        $new_quantity = $row['quantity'] + 1;
        
        $update_sql = "UPDATE cart SET quantity = ? WHERE id = ?";
        $update_stmt = $con->prepare($update_sql);
        $update_stmt->bind_param("ii", $new_quantity, $row['id']);
        $update_stmt->execute();
        $update_stmt->close();
    } else {
        // Item doesn't exist, insert new row
        $insert_sql = "INSERT INTO cart (user_id, medicine_id, name, price, quantity) VALUES (?, ?, ?, ?, 1)";
        $insert_stmt = $con->prepare($insert_sql);
        $insert_stmt->bind_param("iisd", $user_id, $medicine_id, $name, $price);
        $insert_stmt->execute();
        $insert_stmt->close();
    }
    
    $check_stmt->close();
    
    // Return JSON response for AJAX
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
    exit();
}

header("Location: home.php");
exit();
?>
