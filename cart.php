
<?php

session_start();


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
$userName = $isLoggedIn ? htmlspecialchars($_SESSION['full_name']) : 'Guest';


if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Optionally set a warning message
    $_SESSION['login_required'] = "Please login to access the cart.";
    header("Location: login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/svg+xml" href="/vite.svg">
  <title>Your Cart - FreshCart</title>
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
</head>
<body>
    
  <div class="app-container">
    <header id="header">
      <div class="header-container">
        <div class="logo">
          <a href="index.php">Fresh<span>Cart</span></a>         </div>
        <nav>
          <ul>
            <li><a href="index.php">Home</a></li>             <li><a href="products.php">Products</a></li>             <li><a href="cart.php" class="active">Cart <span id="cart-count">0</span></a></li>           </ul>
        </nav>
        <div class="header-actions">
          <button id="search-toggle" class="icon-btn">
            <img src="assets/icons/search.svg" alt="Search" id="search-icon">
          </button>
          <button id="theme-toggle" class="icon-btn">
            <img src="assets/icons/moon.svg" alt="Toggle theme" id="theme-icon">
          </button>
          <div id="user-section">
                <?php if ($isLoggedIn): ?>
                    <span style="margin-right: 10px;">Hello, <?php echo $userName; ?>!</span>
                    <a href="logout.php" class="btn btn-outline">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-outline">Login</a> <?php endif; ?>
          </div>
        </div>
        <button id="mobile-menu-toggle" class="icon-btn mobile-only">
          <span></span>
          <span></span>
          <span></span>
        </button>
      </div>
      <div id="search-container" class="hidden">
        <div class="search-input">
          <input type="text" id="search-input" placeholder="Search products...">
          <button id="close-search" class="icon-btn">
            <img src="assets/icons/close.svg" alt="Close">
          </button>
        </div>
        <div id="search-results"></div>
      </div>
    </header>

    <main>
      <section class="cart-container">
        <h1>Your Shopping Cart</h1>
        
        <div id="cart-content">
          <div id="cart-items">
                      </div>
          
          <div id="cart-empty" class="hidden">
            <div class="empty-cart">
              <img src="assets/icons/cart-empty.svg" alt="Empty Cart">
              <h2>Your cart is empty</h2>
              <p>Looks like you haven't added any items to your cart yet.</p>
              <a href="products.php" class="btn btn-primary">Continue Shopping</a>             </div>
          </div>
          
          <div id="cart-summary" class="cart-summary">
            <h3>Order Summary</h3>
            <div class="summary-line">
              <span>Subtotal</span>
              <span id="cart-subtotal">$0.00</span>
            </div>
            <div class="summary-line">
              <span>Shipping</span>
              <span id="cart-shipping">$0.00</span>
            </div>
            <div class="summary-line">
              <span>Tax</span>
              <span id="cart-tax">$0.00</span>
            </div>
            <div class="summary-line total">
              <span>Total</span>
              <span id="cart-total">$0.00</span>
            </div>
            <button id="checkout-btn" class="btn btn-primary">Proceed to Checkout</button>
            <button id="clear-cart-btn" class="btn btn-outline">Clear Cart</button>
          </div>
        </div>
      </section>
    </main>

    <div id="checkout-modal" class="modal">
      <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h2>Checkout</h2>
        <div class="checkout-form">
                      <div class="form-group">
            <label for="customer-name">Full Name</label>
            <input type="text" id="customer-name" name="customerName" required>           </div>
          <div class="form-group">
            <label for="customer-email">Email</label>
            <input type="email" id="customer-email" name="customerEmail" required>           </div>
          <div class="form-group">
            <label for="customer-address">Delivery Address</label>
            <textarea id="customer-address" name="customerAddress" required></textarea>           </div>
          <div class="form-group">
            <label for="payment-method">Payment Method</label>
            <select id="payment-method" name="paymentMethod" required>               <option value="">-- Select payment method --</option>
              <option value="credit-card">Credit Card</option>
              <option value="debit-card">Debit Card</option>
              <option value="paypal">PayPal</option>
              <option value="cash">Cash on Delivery</option>
            </select>
          </div>
          <div id="order-summary">
            <h3>Order Summary</h3>
            <div class="summary-line total">
              <span>Total</span>
              <span id="modal-cart-total">$0.00</span>
            </div>
          </div>
          <button id="place-order-btn" class="btn btn-primary">Place Order</button>
        </div>
      </div>
    </div>

    <div id="order-confirmation" class="modal">
      <div class="modal-content">
        <h2>Order Confirmed!</h2>
        <p>Thank you for your order. Your groceries are on the way!</p>
        <p>Order #: <span id="order-number"></span></p>
        <a href="products.php" id="continue-shopping" class="btn btn-primary">Continue Shopping</a>

      </div>
    </div>

    <footer>
      <div class="footer-container">
        <div class="footer-section">
          <h3>FreshCart</h3>
          <p>Your go-to grocery store for fresh and quality products delivered right to your doorstep.</p>
        </div>
        <div class="footer-section">
          <h3>Quick Links</h3>
          <ul>
            <li><a href="index.php">Home</a></li>             <li><a href="products.php">Products</a></li>             <li><a href="cart.php">Cart</a></li>             <li><a href="login.php">Login</a></li>           </ul>
        </div>
        <div class="footer-section">
          <h3>Contact Us</h3>
          <p>Email: info@freshcart.com</p>
          <p>Phone: (123) 456-7890</p>
          <p>Address: 123 Grocery St, Fresh City</p>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; 2025 FreshCart. All rights reserved.</p>
      </div>
    </footer>
  </div>

  <script src="js/utils.js"></script>
  <script src="js/products.js"></script>
  <script src="js/darkmode.js"></script>
    <script src="js/cart.js"></script>
  <script src="js/search.js"></script>
  <script src="js/main.js"></script>
  <script src="js/cart-page.js"></script>
</body>
</html>