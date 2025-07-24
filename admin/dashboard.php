<?php
session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
  header("Location: /college_portal/login.php");
  exit();
}

include "../includes/db.php";
include "../includes/layout.php";

$admin_id = $_SESSION['id'];

// Unread messages
$unreadQuery = $conn->query("
  SELECT COUNT(*) AS unread_count
  FROM messages
  WHERE receiver_id = $admin_id AND is_read = 0
");
$unread = $unreadQuery->fetch_assoc()['unread_count'];

// Total students & admins
$students = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role = 'student'")->fetch_assoc()['total'];
$admins = $conn->query("SELECT COUNT(*) AS total FROM users WHERE role = 'admin'")->fetch_assoc()['total'];

// Average marks
$marks_query = $conn->query("
  SELECT student_id, SUM(marks_obtained)/SUM(max_marks)*100 AS average
  FROM marks
  GROUP BY student_id
");

$total_avg = 0;
$count = 0;
while ($row = $marks_query->fetch_assoc()) {
  $total_avg += $row['average'];
  $count++;
}
$avg_percentage = $count > 0 ? round($total_avg / $count, 2) : 0;

// Average attendance
$att_query = $conn->query("
  SELECT student_id, 
  SUM(CASE WHEN status = 'Present' THEN 1 ELSE 0 END)/COUNT(*)*100 AS attendance_rate
  FROM attendance
  GROUP BY student_id
");

$total_att = 0;
$att_count = 0;
while ($row = $att_query->fetch_assoc()) {
  $total_att += $row['attendance_rate'];
  $att_count++;
}
$avg_attendance = $att_count > 0 ? round($total_att / $att_count, 2) : 0;
?>

<h2 class="mb-4">Admin Dashboard</h2>

<?php if ($unread > 0): ?>
  <div class="alert alert-info d-flex align-items-center" role="alert">
    <i class="bi bi-envelope-fill me-2"></i>
    You have <strong><?= $unread ?></strong> unread message<?= $unread > 1 ? 's' : '' ?>.
    <a href="inbox.php" class="ms-2 btn btn-sm btn-outline-primary">View Inbox</a>
  </div>
<?php endif; ?>

<div class="row">
  <div class="col-md-3 mb-4">
    <div class="card text-white bg-primary shadow-sm">
      <div class="card-body">
        <h5 class="card-title">Total Students</h5>
        <p class="display-6">🎓 <?= $students ?></p>
      </div>
    </div>
  </div>

  <div class="col-md-3 mb-4">
    <div class="card text-white bg-secondary shadow-sm">
      <div class="card-body">
        <h5 class="card-title">Total Admins</h5>
        <p class="display-6">🧑‍💼 <?= $admins ?></p>
      </div>
    </div>
  </div>

  <div class="col-md-3 mb-4">
    <div class="card text-white bg-success shadow-sm">
      <div class="card-body">
        <h5 class="card-title">Avg Marks</h5>
        <p class="display-6">📊 <?= $avg_percentage ?>%</p>
      </div>
    </div>
  </div>

  <div class="col-md-3 mb-4">
    <div class="card text-white bg-warning shadow-sm">
      <div class="card-body">
        <h5 class="card-title">Avg Attendance</h5>
        <p class="display-6">📅 <?= $avg_attendance ?>%</p>
      </div>
    </div>
  </div>
</div>

<div class="card mt-4 shadow-sm">
  <div class="card-body">
    <h5 class="card-title">Welcome to the Admin Panel</h5>
    <p class="card-text">
      This overview helps you track student performance, manage data, and communicate efficiently.
      Use the sidebar to navigate admin tools.
    </p>
  </div>
</div>

<?php include "../includes/footer.php"; ?>