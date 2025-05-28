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
    <link rel="stylesheet" href="style/h.css" />
    <title>Web Design Mastery | HealthCare</title>
  </head>
  <body>
    <header>
      <nav class="section__container nav__container">
        <div class="nav__logo">Jan<span>Aushadhi</span></div>
        <ul class="nav__links">
          <li class="link"><a href="#home">Home</a></li>
          <li class="link"><a href="#service">Services</a></li>
          <li class="link"><a href="#products">Products</a></li>
          <li class="link"><a href="#about">About Us</a></li>
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
          <h1>🔍Quality Generic Medicines at Low Prices</h1>
          <p>
           Jan Aushadhi is a government initiative aimed at making quality generic medicines
            available at affordable prices to every citizen of India.Jan Aushadhi empowers people to make informed health choices while reducing their medical expenses, 
            contributing to a healthier and more self-reliant India.


          </p>
          <button class="btn"><a href="#service" style="color:white;">See Services</a></button>
        </div>
      </div>
    </header>
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

    <!-- Products Section -->
    <section class="section__container products__section" id="products">
        <h2 class="section__header">Our Products</h2>
        
         <!-- Search Bar with Voice Input -->
         <form method="GET" action="#products" class="search-box">
    <div class="search-bar-container">
        <img src="https://cdn4.iconfinder.com/data/icons/evil-icons-user-interface/64/magnifier-256.png" alt="magnifier" class="magnifier" />
        
        <input type="text" class="input" id="searchInput" name="search" list="medicineList" placeholder="Search..." 
            value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />

        <img src="https://cdn1.iconfinder.com/data/icons/google-s-logo/150/Google_Icons-25-256.png" alt="mic-icon" class="mic-icon" id="voiceSearch" />
    </div>

    <datalist id="medicineList">
        <!-- Suggestions will be added via JavaScript -->
    </datalist>
</form>


 

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
        $searchQuery = "";
        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $searchQuery = $conn->real_escape_string($_GET['search']);
            $sql .= " WHERE name LIKE '%$searchQuery%'";
        }

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                // Highlight matched medicine
                $isMatched = (!empty($searchQuery) && stripos($row['name'], $searchQuery) !== false);
                $highlightClass = $isMatched ? 'highlighted' : '';

                echo '<div class="product-card ' . $highlightClass . '">';
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
        <p>Our mission is to make healthcare accessible and affordable for everyone. We partner with certified pharmacies and ensure that every product meets the highest standards of quality and safety. From prescription medications to over-the-counter solutions, we have everything you need to stay healthy and well.
        <br>Encourages entrepreneurs to open Jan Aushadhi stores, providing self-employment opportunities.Supported by the Government of India under the Department of Pharmaceuticals.
        Ensures reliability and transparency.
        </p>
    </div>

    <!-- Button Section -->
    <div class="button">
        <a href="https://janaushadhi.gov.in/">Read More</a>
    </div>


    <section class="section__container why__container" id="blog">
      <div class="why__image">
        <img src="https://cdn.finshots.app/images/2023/03/1--2--8-.jpg" alt="why choose us" />
      </div>
      <div class="why__content">
        <h2 class="section__header2">Why Choose Us</h2>
        <p>
        Jan Aushadhi medicines are generic alternatives to branded drugs and are prescribed by doctors across India.
         However, there is no specific list of doctors who exclusively recommend Jan Aushadhi medicines.
        </p>
        <div class="why__grid">
          <span><i class="ri-hand-heart-line"></i></span>
          <div>
            <h4> Quality Assurance</h4>
            <p>
            All medicines are tested and certified by NABL (National Accreditation Board for Testing and Calibration Laboratories).
           
            </p>
          </div>
          <span><i class="ri-government-line"></i></span>
          <div>
            <h4>Government Initiative</h4>
            <p>
            Supported by the Government of India under the Department of Pharmaceuticals.
            </p>
          </div>
          <span><i class="ri-empathize-line"></i></span>
          <div>
            <h4> Affordable Medicines</h4>
            <p>
            Generic medicines sold at Jan Aushadhi stores are 50-90% cheaper than branded alternatives
            </p>
          </div>
        </div>
      </div>
    </section>


    <footer class="footer">
      <div class="section__container footer__container">
        <div class="footer__col">
          <h3>Jan<span>Aushadhi</span></h3>
          <p>
          "In conclusion, Jan Aushadhi is a step towards affordable and accessible healthcare for all. Let’s spread awareness and encourage the use of quality generic medicines to build a healthier India. Together, we can make a difference! Thank you!"
          </p>
          <p>
           
             Let me know if you need any modifications! 😊
          </p>
        </div>
        <div class="footer__col">
          <h4>About Us</h4>
          <p>Home</p>
          <p>About Us</p>
          <p>Work With Us</p>
          <p>Our Blog</p>
          <p>Terms & Conditions</p>
        </div>
        <div class="footer__col">
          <h4>Services</h4>
          <p>Search Terms</p>
          <p>Advance Search</p>
          <p>Privacy Policy</p>
          <p>Suppliers</p>
          <p>Our Stores</p>
        </div>
        <div class="footer__col">
          <h4>Contact Us</h4>
          <p>
            <i class="ri-map-pin-2-fill"></i> 194, Netaji Pally Road, 118/42 Chakbarbaria, Noapara, Barasat, North 24 Parganas, West Bengal – 700125
          </p>
          <p><i class="ri-mail-fill"></i> support@care.com</p>
          <p><i class="ri-phone-fill"></i> +91 98043 39212</p>
        </div>
      </div>
      <div class="footer__bar">
        <div class="footer__bar__content">
          <p>Copyright © 2025 Web Design Mastery. All rights reserved.</p>
          <div class="footer__socials">
            <span><i class="ri-instagram-line"></i></span>
            <span><i class="ri-facebook-fill"></i></span>
            <span><i class="ri-heart-fill"></i></span>
            <span><i class="ri-twitter-fill"></i></span>
          </div>
        </div>
      </div>
    </footer>


    <script src="JS/main.js"></script>
  </body>
</html>