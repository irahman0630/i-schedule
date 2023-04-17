<?php
include "config.php";

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$email = $_POST["email"];
$password = $_POST["password"];
$affiliation = $_POST["affiliation"];

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO user (email, password, affiliation, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $email, $hashed_password, $affiliation);

if ($stmt->execute() === TRUE) {
  echo "success";
} else {
  echo "Error: " . $stmt->error;
}

$stmt->close();
?>
