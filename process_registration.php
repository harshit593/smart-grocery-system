<?php
// Start session for error/success messages
session_start();

// Enable error reporting (VERY IMPORTANT FOR DEBUGGING)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// --- Database Connection ---
$servername = "localhost";
$username = "root"; // Default XAMPP MySQL username
$password = "";     // Default XAMPP MySQL password (empty)
$dbname = "freshcart_db"; // Your database name

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // If connection fails, set an error message and redirect.
    $_SESSION['register_error'] = "Database connection failed: " . $conn->connect_error;
    header("Location: register.php");
    exit();
}

// --- Process Form Submission ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form data using 'name' attributes from the HTML form.
    $fullName = $_POST['fullName'] ?? '';
    $email = $_POST['email'] ?? '';
    $rawPassword = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    $errors = []; // Array to collect all validation errors

    // --- Server-side Validation ---
    if (empty($fullName)) {
        $errors[] = "Full Name is required.";
    }
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (empty($rawPassword)) {
        $errors[] = "Password is required.";
    } elseif (strlen($rawPassword) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }
    if ($rawPassword !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }

    // Check if email already exists in the database
    $stmtCheck = $conn->prepare("SELECT id FROM users WHERE email = ?");
    if ($stmtCheck === false) {
        // Log the error for debugging, but show a generic message to the user.
        error_log("Prepare statement for email check failed: " . $conn->error);
        $errors[] = "A server error occurred during email verification. Please try again.";
    } else {
        $stmtCheck->bind_param("s", $email);
        $stmtCheck->execute();
        $stmtCheck->store_result(); // Needed to check num_rows after execution
        if ($stmtCheck->num_rows > 0) {
            $errors[] = "Email already registered. Please login or use a different email.";
        }
        $stmtCheck->close();
    }

    // --- If Validation Errors Exist ---
    if (!empty($errors)) {
        $_SESSION['register_error'] = implode("<br>", $errors); // Join errors with <br> for display
        header("Location: register.php"); // Redirect back to the registration page
        exit();
    }

    // --- If No Validation Errors, Proceed to Insert User ---

    // Hash the password securely using the recommended function
    $hashedPassword = password_hash($rawPassword, PASSWORD_DEFAULT);

    // Prepare SQL query for inserting new user data
    // Column names here MUST match your 'users' table structure
    $stmtInsert = $conn->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");

    if ($stmtInsert === false) {
        error_log("Prepare statement for user insert failed: " . $conn->error);
        $_SESSION['register_error'] = "A server error occurred during account creation. Please try again.";
        header("Location: register.php");
        exit();
    }

    // Bind parameters to the insert statement: 'sss' for three strings
    $stmtInsert->bind_param("sss", $fullName, $email, $hashedPassword);

    // Execute the insert statement
    if ($stmtInsert->execute()) {
        // Registration successful!
        $_SESSION['register_success'] = "Account created successfully! You can now log in.";
        header("Location: login.php"); // Redirect to the login page after successful registration
        exit();
    } else {
        // Handle database insertion errors (e.g., if UNIQUE constraint fails unexpectedly)
        error_log("Execute statement for user insert failed: " . $stmtInsert->error);
        $_SESSION['register_error'] = "Registration failed: " . $stmtInsert->error; // For debugging, show specific DB error
        // In production, use a generic message like "Registration failed. Please try again."
        header("Location: register.php");
        exit();
    }

    // Close the insert statement
    $stmtInsert->close();

} else {
    // If accessed directly without a POST request, redirect to the registration page.
    header("Location: register.php");
    exit();
}

// Close the database connection at the end of the script
$conn->close();
?>