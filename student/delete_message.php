<?php
include "../includes/db.php";
session_start();

if (!isset($_GET['id'])) {
  header("Location: inbox.php");
  exit;
}

$id = intval($_GET['id']);
$user_id = $_SESSION['id'];

// Only delete if message belongs to user
$conn->query("DELETE FROM messages WHERE id = $id AND receiver_id = $user_id");

header("Location: inbox.php");
exit;
