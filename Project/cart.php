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

$user_id = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="style/home.css">
    <title>Shopping Cart - JanAushadhi</title>
</head>
<body>
    <header>
        <nav class="section__container nav__container">
            <div class="nav__logo">Jan<span>Aushadhi</span></div>
            <ul class="nav__links">
                <li class="link"><a href="home.php#home">Home</a></li>
                <li class="link"><a href="home.php#products">Products</a></li>
                <li class="link"><a href="home.php#about">About Us</a></li>
                <li class="link"><a href="home.php#service">Services</a></li>
                <li class="link"><a href="home.php#pages">Pages</a></li>
                <li class="link"><a href="home.php#blog">Blog</a></li>
                <li class="cart-icon">
                    <a href="cart.php">
                        <i class="ri-shopping-cart-line"></i>
                        <?php
                        $cart_count_sql = "SELECT COUNT(*) as count FROM cart WHERE user_id = ?";
                        $cart_count_stmt = $con->prepare($cart_count_sql);
                        $cart_count_stmt->bind_param("i", $user_id);
                        $cart_count_stmt->execute();
                        $cart_count_result = $cart_count_stmt->get_result();
                        if ($cart_count_result && $cart_row = $cart_count_result->fetch_assoc()) {
                            echo '<span class="cart-count">' . $cart_row['count'] . '</span>';
                        }
                        $cart_count_stmt->close();
                        ?>
                    </a>
                </li>
            </ul>
            <a href="php/logout.php"><button class="btn">Log Out</button></a>
        </nav>
    </header>

    <div class="cart-container">
        <div class="cart-header">
            <h1 class="cart-title">Shopping Cart</h1>
            <button id="clear-cart" class="clear-cart-btn" onclick="clearCart()">Clear Cart</button>
        </div>
        
        <?php        
        $cart_sql = "SELECT c.*, m.image FROM cart c 
                     LEFT JOIN medicines m ON c.medicine_id = m.medicine_id 
                     WHERE c.user_id = ?";
        $cart_stmt = $con->prepare($cart_sql);
        $cart_stmt->bind_param("i", $user_id);
        $cart_stmt->execute();
        $cart_result = $cart_stmt->get_result();
        
        if ($cart_result && $cart_result->num_rows > 0) {
            echo '<table class="cart-table">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Product</th>';
            echo '<th>Name</th>';
            echo '<th>Price</th>';
            echo '<th>Quantity</th>';
            echo '<th>Total</th>';
            echo '<th>Action</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            
            $grand_total = 0;
            while ($item = $cart_result->fetch_assoc()) {
                $total = $item['price'] * $item['quantity'];
                $grand_total += $total;
                
                echo '<tr>';
                echo '<td><img src="' . htmlspecialchars($item['image']) . '" alt="' . htmlspecialchars($item['name']) . '"></td>';
                echo '<td>' . htmlspecialchars($item['name']) . '</td>';
                echo '<td>₹' . number_format($item['price'], 2) . '</td>';
                echo '<td class="cart-quantity">';
                echo '<form action="update_cart.php" method="POST" style="display: flex; align-items: center; gap: 0.5rem;">';
                echo '<input type="hidden" name="cart_id" value="' . $item['id'] . '">';
                echo '<button type="submit" name="action" value="decrease" class="quantity-btn">-</button>';
                echo '<span>' . $item['quantity'] . '</span>';
                echo '<button type="submit" name="action" value="increase" class="quantity-btn">+</button>';
                echo '</form>';
                echo '</td>';
                echo '<td>₹' . number_format($total, 2) . '</td>';
                echo '<td>';
                echo '<form action="update_cart.php" method="POST">';
                echo '<input type="hidden" name="cart_id" value="' . $item['id'] . '">';
                echo '<button type="submit" name="action" value="remove" class="cart-remove">';
                echo '<i class="ri-delete-bin-line"></i>';
                echo '</button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
            
            echo '</tbody>';
            echo '</table>';
            
            echo '<div class="cart-total">';
            echo 'Total: <span>₹' . number_format($grand_total, 2) . '</span>';
            echo '</div>';
            
            echo '<div style="text-align: right;">';
            echo '<button class="checkout-btn">Proceed to Checkout</button>';
            echo '</div>';
        } else {
            echo '<div class="no-results">Your cart is empty</div>';
            echo '<div style="text-align: center; margin-top: 2rem;">';
            echo '<a href="home.php#products" class="btn">Continue Shopping</a>';
            echo '</div>';
        }
        $cart_stmt->close();
        ?>
    </div>

    <script>
    function clearCart() {
        if (!confirm('Are you sure you want to clear your cart? This action cannot be undone.')) {
            return;
        }
        
        fetch('clear_cart.php', {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Refresh the page to show empty cart
                window.location.reload();
            } else {
                alert('Failed to clear cart: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to clear cart. Please try again.');
        });
    }
    </script>
    
    <script src="JS/main.js" defer></script>
</body>
</html>
