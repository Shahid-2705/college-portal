<?php
session_start();
include "../includes/db.php";

$sender_id = $_SESSION['id'];
$receiver_id = $_POST['receiver_id'];
$subject = trim($_POST['subject']);
$message = trim($_POST['message']);
$attachment = null;

// Handle attachment
if (!empty($_FILES['attachment']['name'])) {
  $upload_dir = "../uploads/";
  $filename = basename($_FILES['attachment']['name']);
  $target_file = $upload_dir . $filename;

  if (move_uploaded_file($_FILES['attachment']['tmp_name'], $target_file)) {
    $attachment = $filename;
  }
}

// Insert reply
if ($receiver_id && $subject && $message) {
  $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, subject, message, attachment) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("iisss", $sender_id, $receiver_id, $subject, $message, $attachment);
  $stmt->execute();
  $stmt->close();
  header("Location: inbox.php?reply=success");
  exit();
} else {
  echo "<script>alert('Failed to send reply.'); window.location='inbox.php';</script>";
}
?>