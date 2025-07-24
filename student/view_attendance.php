<?php
include "../includes/layout.php";
include "../includes/db.php";

$student_id = $_SESSION['id'];

$query = $conn->prepare("SELECT subject, date, status FROM attendance WHERE student_id = ? ORDER BY date DESC");
$query->bind_param("i", $student_id);
$query->execute();
$result = $query->get_result();
?>

<h2 class="mb-4"><i class="bi bi-calendar-check-fill"></i> My Attendance</h2>

<?php if ($result->num_rows > 0): ?>
  <table class="table table-bordered">
    <thead class="table-dark">
      <tr>
        <th>Subject</th>
        <th>Date</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
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
  <div class="alert alert-info">No attendance records found.</div>
<?php endif; ?>

<?php include "../includes/footer.php"; ?>