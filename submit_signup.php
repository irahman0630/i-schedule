<?php
include "config.php";
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$email = $_POST["email"];
$password = $_POST["password"];

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO user (email, password, created_at, updated_at) VALUES (?, ?, NOW(), NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $hashed_password);

if ($stmt->execute() === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $stmt->error;
}

$stmt->close();
?>
