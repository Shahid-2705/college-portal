<?php
include "../includes/layout.php";
include "../includes/db.php";

$student_id = $_SESSION['id'];

// Fetch marks for the logged-in student
$query = $conn->prepare("SELECT subject, marks_obtained, max_marks FROM marks WHERE student_id = ?");
$query->bind_param("i", $student_id);
$query->execute();
$result = $query->get_result();
?>

<h2 class="mb-4"><i class="bi bi-bar-chart-line-fill"></i> My Marks</h2>

<?php if ($result->num_rows > 0): ?>
  <div class="table-responsive">
    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>Subject</th>
          <th>Marks Obtained</th>
          <th>Max Marks</th>
          <th>Percentage</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['subject']) ?></td>
            <td><?= $row['marks_obtained'] ?></td>
            <td><?= $row['max_marks'] ?></td>
            <td><?= round(($row['marks_obtained'] / $row['max_marks']) * 100, 2) ?>%</td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
<?php else: ?>
  <div class="alert alert-info">No marks available yet.</div>
<?php endif; ?>

<?php include "../includes/footer.php"; ?>