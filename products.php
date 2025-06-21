<?php
session_start(); 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
$userName = $isLoggedIn ? htmlspecialchars($_SESSION['full_name']) : 'Guest';


?>

<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    echo "<h1>Product Page</h1>";
    echo "<p>Showing details for product ID: $id</p>";
} else {
    echo "<h1>Product Page</h1>";
}
?>

<?php
$searchQuery = isset($_GET['query']) ? strtolower(trim($_GET['query'])) : "";

// Dummy array example
$products = [
    ["id" => 1, "name" => "Apple", "category" => "Fruits"],
    ["id" => 2, "name" => "Salmon", "category" => "Meat"],
    ["id" => 3, "name" => "Broccoli", "category" => "Vegetables"],
];

$filtered = [];
foreach ($products as $p) {
    if (str_contains(strtolower($p["name"]), $searchQuery)) {
        $filtered[] = $p;
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="/vite.svg">
    <title>Products - FreshCart</title>
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
                        <li><a href="index.php">Home</a></li> <li><a href="products.php" class="active">Products</a></li> <li><a href="cart.php">Cart <span id="cart-count">0</span></a></li> </ul>
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
            <section class="products-header">
                <h1>All Products</h1>
                <div class="filter-container">
                    <div class="filter-group">
                        <label for="category-filter">Category:</label>
                        <select id="category-filter">
                            <option value="all">All Categories</option>
                            <option value="fruits">Fruits</option>
                            <option value="vegetables">Vegetables</option>
                            <option value="dairy">Dairy</option>
                            <option value="bakery">Bakery</option>
                            <option value="meat">Meat & Seafood</option>
                            <option value="beverages">Beverages</option>
                            <option value="snacks">Snacks</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="sort-filter">Sort By:</label>
                        <select id="sort-filter">
                            <option value="name-asc">Name: A to Z</option>
                            <option value="name-desc">Name: Z to A</option>
                            <option value="price-asc">Price: Low to High</option>
                            <option value="price-desc">Price: High to Low</option>
                        </select>
                    </div>
                </div>
            </section>

            <section class="products-container">
                <aside class="filters-sidebar">
                    <h3>Filter Products</h3>
                    <div class="filter-section">
                        

                    </div>

                    <div class="filter-section">
                        <h4>Categories</h4>
                        <div class="category-checkboxes">
                            <label><input type="checkbox" class="category-check" value="fruits"> Fruits</label>
                            <label><input type="checkbox" class="category-check" value="vegetables"> Vegetables</label>
                            <label><input type="checkbox" class="category-check" value="dairy"> Dairy</label>
                            <label><input type="checkbox" class="category-check" value="bakery"> Bakery</label>
                            <label><input type="checkbox" class="category-check" value="meat"> Meat & Seafood</label>
                            <label><input type="checkbox" class="category-check" value="beverages"> Beverages</label>
                            <label><input type="checkbox" class="category-check" value="snacks"> Snacks</label>
                        </div>
                    </div>

                    <button id="clear-filters" class="btn btn-outline">Clear All</button>
                </aside>

                <div class="products-main">
                    <div class="active-filters" id="active-filters">
                        </div>

                    <div id="products-grid" class="products-grid">
                        <div class="loading-spinner"></div>
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
    <script src="js/products-page.js"></script>
</body>
</html>