<?php
session_start(); 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
$userName = $isLoggedIn ? htmlspecialchars($_SESSION['full_name']) : 'Guest';


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="/vite.svg">
    <title>FreshCart - Smart Grocery</title>
    <link rel="stylesheet" href="css/style.css">
   

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
</head>
<body>
    <div class="app-container">
        <header id="header">
            <div class="header-container">
                <div class="logo">
                    <a href="index.php">Fresh<span>Cart</span></a> </div>
                <nav>
                    <ul>
                        <li><a href="index.php" class="active">Home</a></li> <li><a href="products.php">Products</a></li> <li><a href="cart.php">Cart <span id="cart-count">0</span></a></li> </ul>
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
                            <a href="logout.php" class="btn btn-outline">Logout</a> <?php else: ?>
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
            <?php if (isset($_SESSION['login_success'])): ?>
                <div class="success-message">
                    <?php echo htmlspecialchars($_SESSION['login_success']); unset($_SESSION['login_success']); ?>
                </div>
            <?php endif; ?>

            <section class="hero">
                <div class="hero-content">
                    <h1>Fresh Groceries Delivered to Your Door</h1>
                    <p>Shop the best quality produce and groceries with our easy-to-use online store.</p>
                    <a href="products.php" class="btn btn-primary">Shop Now</a> </div>
            </section>

            <section class="featured-categories">
                <div class="section-title">
                    <h2>Shop by Category</h2>
                </div>
                <div class="categories-grid">
                    <a href="products.php?category=fruits" class="category-card"> <div class="category-img" style="background-image: url('https://images.pexels.com/photos/1132047/pexels-photo-1132047.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750')"></div>
                        <h3>Fruits</h3>
                    </a>
                    <a href="products.php?category=vegetables" class="category-card"> <div class="category-img" style="background-image: url('https://images.pexels.com/photos/2733918/pexels-photo-2733918.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750')"></div>
                        <h3>Vegetables</h3>
                    </a>
                    <a href="products.php?category=dairy" class="category-card"> <div class="category-img" style="background-image: url('https://images.pexels.com/photos/248412/pexels-photo-248412.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750')"></div>
                        <h3>Dairy</h3>
                    </a>
                    <a href="products.php?category=bakery" class="category-card"> <div class="category-img" style="background-image: url('https://images.pexels.com/photos/1775043/pexels-photo-1775043.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750')"></div>
                        <h3>Bakery</h3>
                    </a>
                </div>
            </section>

            <section class="featured-products">
                <div class="section-title">
                    <h2>Featured Products</h2>
                    <a href="products.php" class="view-all">View All</a> </div>
                <div id="featured-products-grid" class="products-grid">
                    </div>
            </section>

            <section class="promo-banner">
                <div class="promo-content">
                    <h2>Fresh Seasonal Produce</h2>
                    <p>Get 15% off on all seasonal fruits and vegetables this week!</p>
                    <a href="products.php?category=fruits" class="btn btn-secondary">Shop Now</a> </div>
            </section>

            <section class="benefits">
                <div class="benefit">
                    <img src="assets/icons/truck.svg" alt="Fast Delivery">
                    <h3>Fast Delivery</h3>
                    <p>Get your groceries delivered within hours</p>
                </div>
                <div class="benefit">
                    <img src="assets/icons/leaf.svg" alt="Fresh Produce">
                    <h3>Fresh Produce</h3>
                    <p>Quality and freshness guaranteed</p>
                </div>
                <div class="benefit">
                    <img src="assets/icons/shield.svg" alt="Secure Checkout">
                    <h3>Secure Checkout</h3>
                    <p>Safe and convenient payment options</p>
                </div>
                <div class="benefit">
                    <img src="assets/icons/return.svg" alt="Easy Returns">
                    <h3>Easy Returns</h3>
                    <p>Hassle-free return policy</p>
                </div>
            </section>
        </main>

        <footer>
            <div class="footer-container">
                <div class="footer-section">
                    <h3>FreshCart</h3>
                    <p>Your go-to grocery store for fresh and quality products delivered right to your doorstep.</p>
                </div>
                <div class="footer-section">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="index.php">Home</a></li> <li><a href="products.php">Products</a></li> <li><a href="cart.php">Cart</a></li> <li><a href="login.php">Login</a></li> </ul>
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
</body>
</html>