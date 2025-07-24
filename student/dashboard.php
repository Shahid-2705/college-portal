<?php
session_start();

// Redirect to login if not logged in or not a student
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'student') {
  header("Location: /college_portal/login.php");
  exit();
}

include "../includes/db.php";
include "../includes/layout.php";

// Fetch unread message count
$student_id = $_SESSION['id'];
$unreadQuery = $conn->query("
  SELECT COUNT(*) AS unread_count
  FROM messages
  WHERE receiver_id = $student_id AND is_read = 0
");
$unread = $unreadQuery->fetch_assoc()['unread_count'] ?? 0;

// Average marks
$marksQuery = $conn->query("
  SELECT SUM(marks_obtained) / SUM(max_marks) * 100 AS avg_marks
  FROM marks
  WHERE student_id = $student_id
");
$avg_marks = round($marksQuery->fetch_assoc()['avg_marks'] ?? 0, 2);

// Attendance percentage
$attQuery = $conn->query("
  SELECT SUM(CASE WHEN status = 'Present' THEN 1 ELSE 0 END) / COUNT(*) * 100 AS att_rate
  FROM attendance
  WHERE student_id = $student_id
");
$avg_attendance = round($attQuery->fetch_assoc()['att_rate'] ?? 0, 2);
?>

<h2 class="mb-4">Student Dashboard</h2>

<?php if ($unread > 0): ?>
  <div class="alert alert-info d-flex align-items-center" role="alert">
    <i class="bi bi-envelope-fill me-2"></i>
    You have <strong><?= $unread ?></strong> unread message<?= $unread > 1 ? 's' : '' ?>.
    <a href="inbox.php" class="ms-2 btn btn-sm btn-outline-primary">View Inbox</a>
  </div>
<?php endif; ?>

<div class="row">
  <div class="col-md-6 mb-4">
    <div class="card bg-success text-white shadow-sm">
      <div class="card-body">
        <h5 class="card-title">Average Marks</h5>
        <p class="display-6">📊 <?= $avg_marks ?>%</p>
      </div>
    </div>
  </div>

  <div class="col-md-6 mb-4">
    <div class="card bg-warning text-white shadow-sm">
      <div class="card-body">
        <h5 class="card-title">Attendance Rate</h5>
        <p class="display-6">📅 <?= $avg_attendance ?>%</p>
      </div>
    </div>
  </div>
</div>

<div class="card shadow-sm mt-4">
  <div class="card-body">
    <h5 class="card-title">Welcome to Your Student Portal</h5>
    <p class="card-text">
      You can track your academic performance, attendance, and receive messages from the college admin. Use the sidebar
      to explore.
    </p>
  </div>
</div>

<?php include "../includes/footer.php"; ?>