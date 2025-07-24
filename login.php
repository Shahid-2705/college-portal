<?php
session_start();
if (isset($_SESSION['role'])) {
  header("Location: {$_SESSION['role']}/dashboard.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
  <meta charset="UTF-8">
  <title>Login - M.S.K College Portal</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background: linear-gradient(to right, #1e3c72, #2a5298);
    }

    .login-box {
      background: #fff;
      padding: 40px;
      border-radius: 16px;
      text-align: center;
      max-width: 400px;
      width: 100%;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    .role-select .btn {
      width: 100%;
      margin-bottom: 10px;
    }
  </style>
</head>

<body>
  <div class="login-box">
    <h4 class="mb-3 text-primary">Welcome to M.S.K College Portal</h4>
    <p class="text-muted">Select your login type</p>

    <div class="role-select">
      <a href="login_admin.php" class="btn btn-dark">Login as Admin</a>
      <a href="login_student.php" class="btn btn-primary">Login as Student</a>
    </div>
  </div>
</body>

</html>