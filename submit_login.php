<?php
session_start();
include "config.php";

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST["email"];
$password = $_POST["password"];

$sql = "SELECT * FROM user WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row["password"])) {
        // Login successful, create session variables and redirect to main page
        $_SESSION["user_id"] = $row["user_id"];
        $_SESSION["email"] = $row["email"];
        header("Location: login.php");
    } else {
        // Password incorrect, show error message
        echo "Invalid email or password (1).";
    }
} else {
    // User not found, show error message
    echo "Invalid email or password (2).";
}

$stmt->close();
$conn->close();
?>
