<?php
if (!isset($_SESSION)) {
  session_start();
}
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
  <meta charset="UTF-8">
  <title>M.S.K College Portal</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: var(--bg);
      color: var(--text);
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    :root {
      --bg: #f8f9fa;
      --text: #212529;
    }

    .dark-mode {
      --bg: #121212;
      --text: #ffffff;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
    <a class="navbar-brand" href="#">M.S.K College</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <?php if (isset($_SESSION['name'])): ?>
          <li class="nav-item">
            <a class="nav-link" href="#">Welcome, <?php echo $_SESSION['name']; ?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/college_portal/logout.php">Logout</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>
  <div class="container mt-4">