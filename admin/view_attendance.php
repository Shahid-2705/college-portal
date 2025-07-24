<?php
include "../includes/layout.php";
include "../includes/db.php";

$query = $conn->query("
  SELECT u.name AS student_name, a.subject, a.date, a.status
  FROM attendance a
  JOIN users u ON a.student_id = u.id
  ORDER BY a.date DESC
");
?>

<h2 class="mb-4"><i class="bi bi-calendar-week-fill"></i> All Attendance Records</h2>

<?php if ($query->num_rows > 0): ?>
  <table class="table table-bordered table-hover">
    <thead class="table-dark">
      <tr>
        <th>Student</th>
        <th>Subject</th>
        <th>Date</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $query->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['student_name']) ?></td>
          <td><?= htmlspecialchars($row['subject']) ?></td>
          <td><?= htmlspecialchars($row['date']) ?></td>
          <td class="<?= $row['status'] == 'Present' ? 'text-success' : 'text-danger' ?>">
            <?= $row['status'] ?>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
<?php else: ?>
  <div class="alert alert-info">No attendance data available.</div>
<?php endif; ?>

<?php include "../includes/footer.php"; ?>