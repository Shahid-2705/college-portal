<?php
include "../includes/layout.php";
include "../includes/db.php";

$user_id = $_SESSION['id'];

// Fetch all messages for this user
$query = $conn->query("
  SELECT m.*, u.name AS sender_name, u.role AS sender_role
  FROM messages m
  JOIN users u ON m.sender_id = u.id
  WHERE m.receiver_id = $user_id
  ORDER BY m.id DESC
");

// Mark all unread messages as read
$conn->query("UPDATE messages SET is_read = 1 WHERE receiver_id = $user_id AND is_read = 0");
?>

<h2 class="mb-4"><i class="bi bi-inbox-fill"></i> Inbox</h2>

<?php if ($query->num_rows > 0): ?>
  <div class="list-group">
    <?php while ($row = $query->fetch_assoc()): ?>
      <div class="list-group-item list-group-item-action mb-3 shadow-sm rounded">
        <div class="d-flex justify-content-between">
          <h5 class="mb-1"><?= htmlspecialchars($row['subject']) ?></h5>
          <small class="text-muted"><?= date("M d, Y h:i A", strtotime($row['created_at'])) ?></small>
        </div>

        <p class="mb-1 text-secondary"><?= nl2br(htmlspecialchars($row['message'])) ?></p>
        <small class="text-muted">From: <strong><?= htmlspecialchars($row['sender_name']) ?>
            (<?= ucfirst($row['sender_role']) ?>)</strong></small>

        <?php if (!empty($row['attachment'])): ?>
          <div class="mt-2">
            <a href="/college_portal/uploads/<?= urlencode($row['attachment']) ?>" class="btn btn-sm btn-primary"
              target="_blank">
              <i class="bi bi-paperclip"></i> View Attachment
            </a>
          </div>
        <?php endif; ?>

        <!-- Reply Button -->
        <button class="btn btn-outline-secondary btn-sm mt-3" type="button" data-bs-toggle="collapse"
          data-bs-target="#reply<?= $row['id'] ?>">
          <i class="bi bi-reply-fill"></i> Reply
        </button>

        <!-- Reply Form -->
        <div class="collapse mt-3" id="reply<?= $row['id'] ?>">
          <form method="POST" action="reply_message.php" enctype="multipart/form-data">
            <input type="hidden" name="receiver_id" value="<?= $row['sender_id'] ?>">
            <input type="hidden" name="original_subject" value="<?= htmlspecialchars($row['subject']) ?>">

            <div class="mb-2">
              <textarea name="message" class="form-control" placeholder="Type your reply..." required></textarea>
            </div>

            <div class="mb-2">
              <input type="file" name="attachment" class="form-control" accept=".pdf,.doc,.docx,.xls,.xlsx">
            </div>

            <button type="submit" class="btn btn-sm btn-success">
              <i class="bi bi-send-fill"></i> Send Reply
            </button>
          </form>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
<?php else: ?>
  <div class="alert alert-info">You have no messages.</div>
<?php endif; ?>

<?php include "../includes/footer.php"; ?>