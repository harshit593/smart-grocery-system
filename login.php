<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root"; // Default XAMPP MySQL username
$password = "";     // Default XAMPP MySQL password (empty for XAMPP, change if you set one)
$dbname = "freshcart_db"; // Your database name - ENSURE THIS IS CORRECT

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
   
    $_SESSION['login_error'] = "Database connection failed: " . $conn->connect_error;
    error_log("Database Connection Error in login.php: " . $conn->connect_error);
    header("Location: login.php");
    exit(); 
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'] ?? '';
    $rawPassword = $_POST['password'] ?? ''; 

    $errors = []; 

    if (empty($email) || empty($rawPassword)) {
        $errors[] = "Please enter both email and password.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    // If there are validation errors, store them and redirect back
    if (!empty($errors)) {
        $_SESSION['login_error'] = implode("<br>", $errors);
        header("Location: login.php");
        exit();
    }

    $stmt = $conn->prepare("SELECT id, full_name, password FROM users WHERE email = ?");

    if ($stmt === false) {
        $_SESSION['login_error'] = "Failed to prepare database query for login.";
        error_log("Login query prepare failed: " . $conn->error); 
        header("Location: login.php");
        exit();
    }

    
    $stmt->bind_param("s", $email);

    
    $stmt->execute();

    $stmt->store_result(); 

    
    if ($stmt->num_rows === 1) {
       
        $stmt->bind_result($userId, $fullName, $storedHashedPassword);
        $stmt->fetch();

       
        if (password_verify($rawPassword, $storedHashedPassword)) {
          
            $_SESSION['loggedin'] = true; 
            $_SESSION['user_id'] = $userId;
            $_SESSION['full_name'] = $fullName; 

           
            unset($_SESSION['login_error']);
            unset($_SESSION['register_success']);

          
            $_SESSION['login_success'] = "Welcome back, " . htmlspecialchars($fullName) . "!";

           
            header("Location: index.php");
            exit(); 
        } else {
            
            $_SESSION['login_error'] = "Invalid email or password.";
            header("Location: login.php");
            exit();
        }
    } else {
       
        
        $_SESSION['login_error'] = "Invalid email or password.";
        header("Location: login.php");
        exit();
    }

   
    $stmt->close();

}

$conn->close();

$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
$userName = $isLoggedIn ? htmlspecialchars($_SESSION['full_name']) : 'Guest';
?>



<?php if (isset($_SESSION['logout_success'])): ?>
    <div class="success-message">
        <?php echo htmlspecialchars($_SESSION['logout_success']); unset($_SESSION['logout_success']); ?>
    </div>
<?php endif; ?>



<?php if (isset($_SESSION['login_required'])): ?>
    <div class="error-message">
        <?php echo htmlspecialchars($_SESSION['login_required']); unset($_SESSION['login_required']); ?>
    </div>
<?php endif; ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="/vite.svg">
    <title>Login - FreshCart</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap">
</head>
<body>
    <div class="app-container">
        <header id="header">
            <div class="header-container">
                <div class="logo">
                    <a href="index.php">Fresh<span>Cart</span></a>
                </div>
                <nav>
                    <ul>
                        <li><a href="index.php">Home</a></li>
                        <li><a href="products.php">Products</a></li> <li><a href="cart.php">Cart <span id="cart-count">0</span></a></li> </ul>
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
                            <a href="login.php" class="btn btn-outline active">Login</a>
                        <?php endif; ?>
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
                    <h1>Login</h1>
                    <?php if (isset($_SESSION['login_error'])): ?>
                        <div id="login-error" class="error-message">
                            <?php echo htmlspecialchars($_SESSION['login_error']); unset($_SESSION['login_error']); ?>
                        </div>
                    <?php elseif (isset($_SESSION['register_success'])): ?>
                        <div id="register-success" class="success-message">
                            <?php echo htmlspecialchars($_SESSION['register_success']); unset($_SESSION['register_success']); ?>
                        </div>
                    <?php endif; ?>

                    <form id="login-form" action="login.php" method="POST">
                        <div class="form-group">
                            <label for="login-email">Email</label>
                            <input type="email" id="login-email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="login-password">Password</label>
                            <input type="password" id="login-password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </form>

                    <div class="auth-footer">
                        <p>Don't have an account? <a href="register.php">Register</a></p>
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
                        <li><a href="index.php">Home</a></li>
                        <li><a href="products.php">Products</a></li> <li><a href="cart.php">Cart</a></li> <li><a href="login.php">Login</a></li>
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