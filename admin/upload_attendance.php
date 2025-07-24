<?php
include "../includes/layout.php";
include "../includes/db.php";

$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $student_id = intval($_POST['student_id']);
  $subject = trim($_POST['subject']);
  $date = $_POST['date'];
  $status = $_POST['status'];

  if ($student_id && $subject && $date && $status) {
    $stmt = $conn->prepare("INSERT INTO attendance (student_id, subject, date, status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $student_id, $subject, $date, $status);
    if ($stmt->execute()) {
      $success = "Attendance uploaded successfully.";
    } else {
      $error = "Failed to upload attendance.";
    }
    $stmt->close();
  } else {
    $error = "All fields are required.";
  }
}

$students = $conn->query("SELECT id, name FROM users WHERE role = 'student'");
?>

<h2 class="mb-4"><i class="bi bi-calendar-check-fill"></i> Upload Attendance</h2>

<?php if ($success): ?>
  <div class="alert alert-success"><?= $success ?></div>
<?php elseif ($error): ?>
  <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<form method="POST" class="card p-4 shadow-sm">
  <div class="mb-3">
    <label for="student_id" class="form-label">Student</label>
    <select name="student_id" class="form-select" required>
      <option value="">Select a student</option>
      <?php while ($row = $students->fetch_assoc()): ?>
        <option value="<?= $row['id'] ?>"><?= htmlspecialchars($row['name']) ?></option>
      <?php endwhile; ?>
    </select>
  </div>

  <div class="mb-3">
    <label for="subject" class="form-label">Subject</label>
    <input type="text" name="subject" class="form-control" required>
  </div>

  <div class="mb-3">
    <label for="date" class="form-label">Date</label>
    <input type="date" name="date" class="form-control" required>
  </div>

  <div class="mb-3">
    <label for="status" class="form-label">Status</label>
    <select name="status" class="form-select" required>
      <option value="Present">Present</option>
      <option value="Absent">Absent</option>
    </select>
  </div>

  <button type="submit" class="btn btn-primary">
    <i class="bi bi-check-square-fill"></i> Submit
  </button>
</form>

<?php include "../includes/footer.php"; ?>