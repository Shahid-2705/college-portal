<?php
include "../includes/layout.php";
include "../includes/db.php";

$sender_id = $_SESSION['id'];
$success = $error = "";

// Fetch only admins
$users = $conn->query("SELECT id, name FROM users WHERE role = 'admin'");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $receiver_ids = $_POST['receiver_ids'] ?? [];
  $subject = trim($_POST['subject']);
  $message = trim($_POST['message']);
  $attachment = null;

  // Upload file if exists
  if (!empty($_FILES['attachment']['name'])) {
    $upload_dir = "../uploads/";
    if (!file_exists($upload_dir))
      mkdir($upload_dir, 0777, true);

    $filename = basename($_FILES['attachment']['name']);
    $target_file = $upload_dir . $filename;

    if (move_uploaded_file($_FILES['attachment']['tmp_name'], $target_file)) {
      $attachment = $filename;
    } else {
      $error = "Failed to upload the attachment.";
    }
  }

  if (!$error && $receiver_ids && $subject && $message) {
    $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, subject, message, attachment) VALUES (?, ?, ?, ?, ?)");
    foreach ($receiver_ids as $receiver_id) {
      $stmt->bind_param("iisss", $sender_id, $receiver_id, $subject, $message, $attachment);
      $stmt->execute();
    }
    $stmt->close();
    $success = "Message sent successfully.";
  } else if (!$error) {
    $error = "All fields are required.";
  }
}
?>

<!-- Select2 CSS and JS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<h2 class="mb-4"><i class="bi bi-send"></i> Send Message to Admin</h2>

<?php if ($success): ?>
  <div class="alert alert-success"><?= $success ?></div>
<?php endif; ?>
<?php if ($error): ?>
  <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
  <div class="mb-3">
    <label class="form-label">Send To (Admin only)</label>
    <select name="receiver_ids[]" id="receiver_ids" class="form-select" required>
      <option value="" disabled selected>Select admin</option>
      <?php while ($row = $users->fetch_assoc()): ?>
        <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
      <?php endwhile; ?>
    </select>
  </div>

  <div class="mb-3">
    <label class="form-label">Subject</label>
    <input type="text" name="subject" class="form-control" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Message</label>
    <textarea name="message" class="form-control" rows="4" required></textarea>
  </div>

  <div class="mb-3">
    <label class="form-label">Attachment (optional)</label>
    <input type="file" name="attachment" class="form-control" accept=".pdf,.doc,.docx,.xls,.xlsx">
  </div>

  <button type="submit" class="btn btn-primary"><i class="bi bi-send-fill"></i> Send</button>
</form>

<script>
  $(document).ready(function () {
    $('#receiver_ids').select2({
      placeholder: "Select an admin",
      width: '100%'
    });
  });
</script>

<?php include "../includes/footer.php"; ?>