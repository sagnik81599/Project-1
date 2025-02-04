<?php 
   session_start();

   include("php/config.php");
   if(!isset($_SESSION['valid'])){
    header("Location: index.php");
    exit();
   }

   if(!isset($_SESSION['id'])){
    header("Location: index.php");
    exit();
   }

   $user_id = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="style/h1.css" />
    <title>Web Design Mastery | HealthCare</title>
  </head>
  <body>
    <header>
      <nav class="section__container nav__container">
        <div class="nav__logo">Jan<span>Aushadhi</span></div>
        <ul class="nav__links">
          <li class="link"><a href="#home">Home</a></li>
          <li class="link"><a href="#products">Products</a></li>
          <li class="link"><a href="#about">About Us</a></li>
          <li class="link"><a href="#service">Services</a></li>
          <li class="link"><a href="#pages">Pages</a></li>
          <li class="link"><a href="#blog">Blog</a></li>
          <li class="cart-icon">
            <a href="cart.php">
              <i class="ri-shopping-cart-line"></i>
              <?php
                // Get cart count
                $cart_sql = "SELECT COUNT(*) as count FROM cart WHERE user_id = ?";
                $cart_stmt = $con->prepare($cart_sql);
                $cart_stmt->bind_param("i", $user_id);
                $cart_stmt->execute();
                $cart_result = $cart_stmt->get_result();
                if ($cart_result && $cart_row = $cart_result->fetch_assoc()) {
                    echo '<span class="cart-count">' . $cart_row['count'] . '</span>';
                }
                $cart_stmt->close();
              ?>
            </a>
          </li>
        </ul>
        <a href="php/logout.php"> <button class="btn">Log Out</button></a>
        <div class="hamburger" id="hamburger">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </nav>
    
      <div class="section__container header__container" id="home">
        <div class="header__content">
          <h1>Say Goodbye to high medicine prices</h1>
          <p>
            Get the best medical care and advice from our exports.
            We provide high-quality medicines at affordable prices
          </p>
          <button class="btn">See Services</button>
        </div>
      </div>
    </header>

    <!-- Products Section -->
    <section class="section__container products__section" id="products">
        <h2 class="section__header">Our Products</h2>
        
        <!-- Search Bar -->
        <!-- <div class="search__container">
            <form method="GET" action="#products" class="search__form">
                <input type="text" name="search" placeholder="Search medicines..." 
                    value="" 
                    class="search__input">
                <button type="submit" class="search__btn">
                    <i class="ri-search-line"></i>
                </button>
            </form>
        </div> -->
         <form method="GET"  action="#products" class="search-box">

        <div class="search-bar-container">
		<img src="https://cdn4.iconfinder.com/data/icons/evil-icons-user-interface/64/magnifier-256.png" alt="magnifier" class="magnifier" />
		<input type="text" class="input" name="search" placeholder="Search..." /><?php echo isset($_GET['search']) ?>
		<img src="https://cdn1.iconfinder.com/data/icons/google-s-logo/150/Google_Icons-25-256.png" alt="mic-icon" class="mic-icon" />

              </form>
                </div>

        <div class="products__grid">
            <?php
            // Database connection details
            $servername = "localhost";
            $username = "root";
            $password = ""; 
            $database = "project-1";
           

            // Create connection
            $conn = new mysqli($servername, $username, $password, $database);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Prepare the SQL query based on search
            $sql = "SELECT medicine_id, name, image, price FROM medicines";
            if (isset($_GET['search']) && !empty($_GET['search'])) {
                $search = $conn->real_escape_string($_GET['search']);
                $sql .= " WHERE name LIKE '%$search%'";
            }

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="product-card">';
                    echo '<img src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '">';
                    echo '<h3>' . htmlspecialchars($row['name']) . '</h3>';
                    echo '<p class="price">₹' . number_format($row['price'], 2) . '</p>';
                    echo '<form class="add-to-cart-form" onsubmit="return addToCart(event)">';
                    echo '<input type="hidden" name="medicine_id" value="' . $row['medicine_id'] . '">';
                    echo '<input type="hidden" name="name" value="' . htmlspecialchars($row['name']) . '">';
                    echo '<input type="hidden" name="price" value="' . $row['price'] . '">';
                    echo '<button type="submit" class="add-to-cart">Add to Cart</button>';
                    echo '</form>';
                    echo '</div>';
                }
            } else {
                echo '<div class="no-results">No products found</div>';
            }
            $conn->close();
            ?>
        </div>
    </section>

    <!-- service section -->
    <section class="section__container service__container" id="service">
            <div class="service__header">
              <div class="service__header__content">
                <h2 class="section__header">Our Special service</h2>
                <p>
                  Beyond simply providing medical care, our commitment lies in
                  delivering unparalleled service tailored to your unique needs.
                </p>
              </div>
              <button class="service__btn">Ask A Service</button>
            </div>
            <div class="service__grid">
              <div class="service__card">
                <span><i class="ri-truck-fill"></i></span>
                <h4>Free Delivery</h4>
                <p>
                  Accurate Diagnostics, Swift Results: Experience top-notch Laboratory
                  Testing at our facility.
                </p>
                <a href="#">Learn More</a>
              </div>
              <div class="service__card">
                <span><i class="ri-capsule-fill"></i></span>
                <h4>New Medicine Everyday</h4>
                <p>
                  Our thorough assessments and expert evaluations help you stay
                  proactive about your health.
                </p>
                <a href="#">Learn More</a>
              </div>
              <div class="service__card">
                <span><i class="ri-microscope-fill"></i></span>
                <h4>General Dentistry</h4>
                <p>
                  Experience comprehensive oral care with Dentistry. Trust us to keep
                  your smile healthy and bright.
                </p>
                <a href="#">Learn More</a>
              </div>
            </div>
          </section>

    <!-- About section -->
    <div class="title" id="about">
      <h1>About Us</h1>
    </div>

    <!-- Image Section -->
    <div class="image-section">
        <img src="https://medlineplus.gov/images/Medicines_share.jpg" alt="Janaushadhi Online Medicine Shop" style="height: 250px; width: 500px;">
    </div>

    <!-- Content Section -->
    <div class="content">
        <h3>Welcome to Janaushadhi Online Delivery Shop</h3>
        <p>At Janaushadhi Online Delivery Shop, we are committed to providing high-quality medicines<br> at affordable prices. Our easy-to-use online platform allows you to browse and order a wide range of medications and health products from the comfort of your home. Enjoy the convenience of home delivery, ensuring you never miss out on your essential medications. Explore our offerings and experience reliable service with just a few clicks.</p>
        <p>Our mission is to make healthcare accessible and affordable for everyone. We partner with certified pharmacies and ensure that every product meets the highest standards of quality and safety. From prescription medications to over-the-counter solutions, we have everything you need to stay healthy and well.</p>
    </div>

    <!-- Button Section -->
    <div class="button">
        <a href="#">Read More</a>
    </div>

    <!-- Social Media Links -->
    <div class="social">
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
    </div>

    <script src="JS/m.js"></script>
  </body>
</html>