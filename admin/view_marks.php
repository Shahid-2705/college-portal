<?php
include "../includes/layout.php";
include "../includes/db.php";

// Fetch marks data
$query = $conn->query("
  SELECT u.name AS student_name, m.subject, m.marks_obtained, m.max_marks
  FROM marks m
  JOIN users u ON m.student_id = u.id
  ORDER BY u.name, m.subject
");

// Prepare data
$studentScores = [];
$studentMax = [];
$rows = [];

while ($row = $query->fetch_assoc()) {
  $name = $row['student_name'];
  $studentScores[$name] = ($studentScores[$name] ?? 0) + $row['marks_obtained'];
  $studentMax[$name] = ($studentMax[$name] ?? 0) + $row['max_marks'];
  $rows[] = $row;
}
?>

<h2 class="mb-4"><i class="bi bi-bar-chart-line-fill"></i> All Students' Marks</h2>

<?php if (!empty($rows)): ?>
  <div class="table-responsive">
    <table class="table table-bordered table-hover">
      <thead class="table-dark">
        <tr>
          <th>Student Name</th>
          <th>Subject</th>
          <th>Marks Obtained</th>
          <th>Max Marks</th>
          <th>Percentage</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $row): ?>
          <tr>
            <td><?= htmlspecialchars($row['student_name']) ?></td>
            <td><?= htmlspecialchars($row['subject']) ?></td>
            <td><?= $row['marks_obtained'] ?></td>
            <td><?= $row['max_marks'] ?></td>
            <td><?= round(($row['marks_obtained'] / $row['max_marks']) * 100, 2) ?>%</td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <h4 class="mt-5 mb-3"><i class="bi bi-bar-chart-fill"></i> Average Percentage by Student</h4>
  <div style="max-width: 100%; overflow-x: auto;">
    <canvas id="marksChart" style="height: 400px;"></canvas>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const ctx = document.getElementById('marksChart').getContext('2d');
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: <?= json_encode(array_keys($studentScores)) ?>,
          datasets: [{
            label: 'Average %',
            data: <?= json_encode(array_map(function ($obtained, $max) {
              return round(($obtained / $max) * 100, 2);
            }, $studentScores, $studentMax)) ?>,
            backgroundColor: 'rgba(13, 202, 240, 0.7)',
            borderColor: 'rgba(13, 202, 240, 1)',
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          scales: {
            y: {
              beginAtZero: true,
              max: 100
            }
          },
          plugins: {
            legend: {
              position: 'top',
            },
            title: {
              display: false
            }
          }
        }
      });
    });
  </script>

<?php else: ?>
  <div class="alert alert-info">No marks have been uploaded yet.</div>
<?php endif; ?>

<?php include "../includes/footer.php"; ?>