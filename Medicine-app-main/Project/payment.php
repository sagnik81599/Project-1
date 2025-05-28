<?php 
session_start();
include("php/config.php");

if (!isset($_SESSION['valid']) || !isset($_SESSION['id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['id'];
$total_price = isset($_SESSION['total_price']) ? $_SESSION['total_price'] : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Responsive Payment Form</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background-image: linear-gradient(
        to right,
        rgba(18, 172, 142, 0.9),
        rgba(18, 172, 142, 0.7)
      ),   
      url("./pay_img/payback.jpg"); 
      background-size: auto;
      margin: 0;
      padding: 20px;
    }

    .container {
      max-width: 850px;
      margin: auto;
      background: white;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-wrap: wrap;
    }

    .section {
      flex: 1;
      min-width: 280px;
      padding: 20px;
    }

    h3 {
      margin-bottom: 20px;
      font-size: 20px;
      color: #333;
    }

    label {
      display: block;
      margin-top: 10px;
      font-weight: 600;
    }

    input[type="text"],
    input[type="email"],
    select {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 6px;
      transition: border 0.3s ease;
    }

    input:focus {
      border-color: #7b6df6;
      outline: none;
    }

    .cards img {
      height: 30px;
      margin: 5px 10px 10px 0;
    }

    .upi-option {
      margin-top: 20px;
      padding: 15px;
      background: #f9f9f9;
      border-radius: 10px;
      border: 1px solid #ddd;
    }

    .upi-option label {
      font-weight: normal;
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 16px;
    }

    .upi-option input[type="checkbox"] {
      transform: scale(1.3);
      accent-color: #7b6df6;
      cursor: pointer;
    }

    #qr-code {
      display: none;
      margin-top: 15px;
      text-align: center;
    }

    #qr-code img {
      max-width: 180px;
      border-radius: 10px;
      margin-bottom: 10px;
    }

    #qr-code label {
      font-weight: 600;
      margin-top: 10px;
      display: block;
      color: #555;
    }

    #qr-code input[type="text"] {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 6px;
      transition: border 0.3s ease;
    }

    .total-amount {
      font-size: 20px;
      font-weight: bold;
      margin-top: 30px;
      color: #222;
      background-color: #f2f2f2;
      padding: 15px;
      border-radius: 8px;
      text-align: center;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }

    .submit-container {
      width: 100%;
      text-align: center;
      margin-top: 30px;
      display: flex;
      justify-content: center;
      gap: 20px;
      flex-wrap: wrap;
    }

    .back-btn,
    .submit-btn {
      padding: 12px 30px;
      font-size: 16px;
      font-weight: bold;
      border-radius: 8px;
      cursor: pointer;
      border: none;
      transition: background-color 0.3s ease;
    }

    .submit-btn {
      background-color: #7b6df6;
      color: white;
    }

    .submit-btn:hover {
      background-color: #6955f8;
    }

    .back-btn {
      background-color: #e0e0e0;
      color: #333;
    }

    .back-btn:hover {
      background-color: #ccc;
    }

    @media (max-width: 768px) {
      .container {
        flex-direction: column;
      }
    }

    @media (max-width: 500px) {
      .submit-container {
        flex-direction: column;
        gap: 10px;
      }

      .submit-btn,
      .back-btn {
        width: 100%;
      }
    }
  </style>
</head>
<body>

<div class="container">
  <div class="section">
    <h3>BILLING ADDRESS</h3>
    <label>Full Name:</label>
    <input type="text" placeholder="Enter name">
    <label>Email:</label>
    <input type="email" placeholder="example@example.com">
    <label>Address:</label>
    <input type="text" placeholder="- Street - Locality">
    <label>City:</label>
    <input type="text" placeholder="">
    <label>State:</label>
    <input type="text" placeholder="">
    <label>Zip Code:</label>
    <input type="text" placeholder="">
  </div>

  <div class="section">
    <h3>PAYMENT</h3>
    <label>Cards Accepted:</label>
    <div class="cards">
      <img src="pay_img/imgcards.png" alt="Cards Accepted">
    </div>
    <label>Name on Card:</label>
    <input type="text" placeholder="">
    <label>Credit Card Number:</label>
    <input type="text" placeholder="">
    <label>Exp. Month:</label>
    <input type="text" placeholder="">
    <label>Exp. Year:</label>
    <input type="text" placeholder="">
    <label>CVV:</label>
    <input type="text" placeholder="123">

    <div class="upi-option">
      <label>
        <input type="checkbox" id="upi-check">
        Pay via UPI (Scan QR Code)
      </label>
      <div id="qr-code">
        <p>Scan the QR Code below to pay:</p>
        <img src="pay_img/qr_M.jpg" alt="UPI QR Code">
        <label for="upi-id">Enter UPI ID (optional):</label>
        <input type="text" id="upi-id" placeholder="example@upi">
      </div>
    </div>

    <div class="total-amount">
      Total Amount: ₹<?php echo number_format($total_price, 2); ?>
    </div>

    <div class="submit-container">
      <button class="submit-btn">Submit Payment</button>
      <a href="cart.php"><button class="back-btn">Back</button></a>
    </div>
  </div>
</div>

<script>
  document.getElementById("upi-check").addEventListener("change", function () {
    const qr = document.getElementById("qr-code");
    qr.style.display = this.checked ? "block" : "none";
  });
</script>

</body>
</html>
