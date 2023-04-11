<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    // User not logged in, redirect to login page
    header("Location: login.php");
}

// Get user information from session variables
$user_id = $_SESSION["user_id"];
$email = $_SESSION["email"];

// Display user-specific content here
?>

<!DOCTYPE html>
<html>
<head>
    <title>Main Page</title>
</head>
<body>
    <h1>Welcome, <?php echo $email; ?>!</h1>
    <!-- Display user-specific content here -->
</body>
</html>
