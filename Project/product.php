<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = ""; // Use your MySQL password if needed
$database = "project-1";



// Create connection
$conn = new mysqli($servername, $username, $password, $database,);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch products from the medicines table
$sql = "SELECT medicine_id, name, image, price FROM medicines";
$result = $conn->query($sql);
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medicine Store</title>
    <link rel="stylesheet" href="style/p.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>
<body> 


<nav class="navbar">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <!-- Navbar Brand -->
      <a class="navbar-brand" href="#">Janaushadhi</a>

      <!-- Search Box and Cart -->
      <div class="d-flex search-cart-container align-items-center">
        <!-- Search Box -->
        <div class="search-box">
          <button><i class="fas fa-search"></i></button>
          <input type="text" placeholder="Search medicines, products, and brands">
        </div>

        <!-- Cart Icon -->
        <a href="#" class="btn-cart position-relative ms-3">
          <i class="fas fa-shopping-cart"></i>
          
        </a>
      </div>
    </div>
  </nav>





    <!-- Product Container -->
    <div class="product-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '
                <div class="product-card">
                    <img src="' . htmlspecialchars($row["image"]) . '" alt="' . htmlspecialchars($row["name"]) . '" class="product-image">
                    <p class="product-name">' . htmlspecialchars($row["name"]) . '</h2>
                    <p class="product-price">Rs ' . number_format($row["price"], 2) . '</p>
                    <button class="add-to-cart-btn" onclick="addToCart(' . $row["medicine_id"] . ', \'' . addslashes($row["name"]) . '\', ' . $row["price"] . ')">Add to Cart</button>
                </div>';
            }
        } else {
            echo "<p>No products available.</p>";
        }
        ?>
    </div>



    <script src="product.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
  
</body>
</html>

<?php
$conn->close();
?>

