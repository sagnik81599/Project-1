<?php
session_start();
include("php/config.php");

if(!isset($_SESSION['valid'])) {
    header("Location: index.php");
    exit();
}

if(!isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cart_id = $_POST['cart_id'];
    $action = $_POST['action'];
    
    switch($action) {
        case 'increase':
            $sql = "UPDATE cart SET quantity = quantity + 1 WHERE id = ? AND user_id = ?";
            $_SESSION['cart_message'] = "Quantity increased successfully!";
            break;
            
        case 'decrease':
            // First check current quantity
            $check_sql = "SELECT quantity FROM cart WHERE id = ? AND user_id = ?";
            $check_stmt = $con->prepare($check_sql);
            $check_stmt->bind_param("ii", $cart_id, $_SESSION['id']);
            $check_stmt->execute();
            $result = $check_stmt->get_result();
            
            if ($row = $result->fetch_assoc()) {
                if ($row['quantity'] > 1) {
                    $sql = "UPDATE cart SET quantity = quantity - 1 WHERE id = ? AND user_id = ?";
                    $_SESSION['cart_message'] = "Quantity decreased successfully!";
                } else {
                    $sql = "DELETE FROM cart WHERE id = ? AND user_id = ?";
                    $_SESSION['cart_message'] = "Item removed from cart!";
                }
            }
            $check_stmt->close();
            break;
            
        case 'remove':
            $sql = "DELETE FROM cart WHERE id = ? AND user_id = ?";
            $_SESSION['cart_message'] = "Item removed from cart!";
            break;
            
        default:
            header("Location: cart.php");
            exit();
    }
    
    if (isset($sql)) {
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ii", $cart_id, $_SESSION['id']);
        $stmt->execute();
        $stmt->close();
    }
}

header("Location: cart.php");
exit();
?>
