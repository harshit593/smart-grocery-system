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
    <title>Register - FreshCart</title>
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
                        <li><a href="index.php">Home</a></li> <li><a href="products.php">Products</a></li> <li><a href="cart.php">Cart <span id="cart-count">0</span></a></li> </ul>
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
            <section class="auth-container">
                <div class="auth-card">
                    <h1>Create an Account</h1>
                    <?php if (isset($_SESSION['register_error'])): ?>
                        <div id="register-error" class="error-message">
                            <?php echo htmlspecialchars($_SESSION['register_error']); unset($_SESSION['register_error']); ?>
                        </div>
                    <?php elseif (isset($_SESSION['register_success'])): ?>
                        <div id="register-success" class="success-message">
                            <?php echo htmlspecialchars($_SESSION['register_success']); unset($_SESSION['register_success']); ?>
                        </div>
                    <?php endif; ?>

                    <form id="register-form" action="process_registration.php" method="POST">
                        <div class="form-group">
                            <label for="register-name">Full Name</label>
                            <input type="text" id="register-name" name="fullName" required>
                        </div>
                        <div class="form-group">
                            <label for="register-email">Email</label>
                            <input type="email" id="register-email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="register-password">Password</label>
                            <input type="password" id="register-password" name="password" required minlength="6">
                            <small>Password must be at least 6 characters</small>
                        </div>
                        <div class="form-group">
                            <label for="register-confirm-password">Confirm Password</label>
                            <input type="password" id="register-confirm-password" name="confirmPassword" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Create Account</button>
                    </form>

                    <div class="auth-footer">
                        <p>Already have an account? <a href="login.php">Login</a></p>
                    </div>
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
                        <li><a href="index.php">Home</a></li> <li><a href="products.php">Products</a></li> <li><a href="cart.php">Cart</a></li> <li><a href="login.php">Login</a></li>
                    </ul>
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
    <script src="js/darkmode.js"></script>
    <script src="js/cart.js"></script>
    <script src="js/search.js"></script>
    <script src="js/main.js"></script>
</body>
</html>