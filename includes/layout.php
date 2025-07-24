<?php
if (!isset($_SESSION))
  session_start();
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
  <meta charset="UTF-8" />
  <title>M.S.K College Portal</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    * {
      box-sizing: border-box;
    }

    html,
    body {
      margin: 0;
      padding: 0;
      height: 100%;
      font-family: 'Segoe UI', sans-serif;
    }

    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .wrapper {
      display: flex;
      flex-grow: 1;
    }

    .sidebar {
      width: 250px;
      background-color: #1a1a1a;
      color: white;
      padding: 20px;
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      overflow-y: auto;
      z-index: 1040;
    }

    .sidebar img {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      margin-bottom: 10px;
    }

    .sidebar h5 {
      color: #0dcaf0;
      margin-bottom: 20px;
    }

    .sidebar a {
      color: #ccc;
      display: block;
      padding: 10px;
      border-radius: 6px;
      text-decoration: none;
      transition: all 0.2s ease;
    }

    .sidebar a:hover,
    .sidebar a.active {
      background-color: #343a40;
      color: #fff;
    }

    .topbar {
      background-color: #212529;
      color: #fff;
      padding: 15px 20px;
      position: fixed;
      left: 250px;
      right: 0;
      top: 0;
      z-index: 1030;
    }

    .main-content {
      margin-left: 250px;
      padding: 90px 20px 20px;
      width: 100%;
      background-color: #f8f9fa;
      min-height: calc(100vh - 56px);
      /* Leaves space for footer */
    }

    @media (max-width: 768px) {
      .sidebar {
        display: none;
      }

      .topbar {
        left: 0;
      }

      .main-content {
        margin-left: 0;
        padding-top: 80px;
      }
    }
  </style>
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar">
      <div class="text-center">
        <img src="/college_portal/assets/logo.png" alt="M.S.K Logo">
        <h5>M.S.K Portal</h5>
      </div>
      <hr class="border-light">

      <a href="/college_portal/<?php echo $_SESSION['role']; ?>/dashboard.php">
        <i class="bi bi-house-door-fill"></i> Dashboard
      </a>

      <?php if ($_SESSION['role'] === 'admin'): ?>
        <a href="/college_portal/admin/add_user.php"><i class="bi bi-person-plus-fill"></i> Add User</a>
        <a href="/college_portal/admin/send_message.php"><i class="bi bi-envelope-fill"></i> Send Message</a>
        <a href="/college_portal/admin/inbox.php"><i class="bi bi-inbox-fill"></i> Inbox</a>
        <a href="/college_portal/admin/upload_marks.php"><i class="bi bi-file-earmark-bar-graph-fill"></i> Upload
          Marks</a>
        <a href="/college_portal/admin/view_marks.php"><i class="bi bi-graph-up"></i> View Marks</a>
        <a href="/college_portal/admin/upload_attendance.php"><i class="bi bi-calendar-check-fill"></i> Upload
          Attendance</a>
        <a href="/college_portal/admin/view_attendance.php"><i class="bi bi-calendar-event"></i> View Attendance</a>
      <?php else: ?>
        <a href="/college_portal/student/view_marks.php"><i class="bi bi-bar-chart-line-fill"></i> View Marks</a>
        <a href="/college_portal/student/view_attendance.php"><i class="bi bi-calendar-check-fill"></i> View
          Attendance</a>
        <a href="/college_portal/student/inbox.php"><i class="bi bi-inbox-fill"></i> Inbox</a>
        <a href="/college_portal/student/send_message.php"><i class="bi bi-send-fill"></i> Send Message</a>
      <?php endif; ?>

      <hr class="border-light">
      <a href="/college_portal/logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>

    <!-- Content Area -->
    <div class="main-content">
      <div class="topbar d-flex justify-content-between align-items-center">
        <span>Welcome, <?= $_SESSION['name'] ?></span>
        <button class="btn btn-sm btn-outline-light" onclick="toggleTheme()">🌓 Theme</button>
      </div>