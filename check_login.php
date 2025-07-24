<?php
session_start();
include "includes/db.php";

// Get credentials
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$role = $_POST['role'] ?? '';

if (!$email || !$password || !$role) {
  echo "<script>alert('All fields are required'); window.location.href='login.php';</script>";
  exit();
}

// Use prepared statement to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ? AND role = ?");
$stmt->bind_param("sss", $email, $password, $role);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
  $user = $result->fetch_assoc();

  // Set session
  $_SESSION['id'] = $user['id'];
  $_SESSION['name'] = $user['name'];
  $_SESSION['role'] = $user['role'];

  // Redirect based on role
  header("Location: {$user['role']}/dashboard.php");
  exit();
} else {
  echo "<script>alert('Invalid email, password, or role'); window.location.href='login.php';</script>";
}
?>