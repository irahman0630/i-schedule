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
        $_SESSION["user_id"] = $row["user_id"];
        $_SESSION["email"] = $row["email"];
        header("Location: dashboard.php");
    } else {
        echo "Invalid email or password.";
    }
} else {
    echo "Invalid email or password.";
}

$stmt->close();
$conn->close();
?>
