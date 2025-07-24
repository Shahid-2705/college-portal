<?php
include "../includes/layout.php";
include "../includes/db.php";

if (!isset($_GET['id'])) {
  echo "<div class='alert alert-danger'>Invalid message ID.</div>";
  include "../includes/footer.php";
  exit();
}

$message_id = intval($_GET['id']);
$user_id = $_SESSION['id'];

// Mark the message as read
$conn->query("UPDATE messages SET is_read = 1 WHERE id = $message_id AND receiver_id = $user_id");

// Fetch the message
$result = $conn->query("SELECT m.*, u.name AS sender_name, u.role AS sender_role
                        FROM messages m
                        JOIN users u ON m.sender_id = u.id
                        WHERE m.id = $message_id AND m.receiver_id = $user_id");

if ($result->num_rows == 0) {
  echo "<div class='alert alert-warning'>Message not found.</div>";
  include "../includes/footer.php";
  exit();
}

$message = $result->fetch_assoc();
?>

<div class="card shadow-sm mt-4">
  <div class="card-body">
    <h5 class="card-title"><?= htmlspecialchars($message['subject']) ?></h5>
    <h6 class="card-subtitle text-muted mb-2">
      From: <?= htmlspecialchars($message['sender_name']) ?> (<?= ucfirst($message['sender_role']) ?>)
    </h6>
    <p class="card-text mt-3"><?= nl2br(htmlspecialchars($message['message'])) ?></p>

    <?php if ($message['attachment']): ?>
      <a href="../uploads/<?= $message['attachment'] ?>" class="btn btn-outline-primary mt-3" target="_blank">
        <i class="bi bi-paperclip"></i> View Attachment
      </a>
    <?php endif; ?>
  </div>
</div>

<?php include "../includes/footer.php"; ?>