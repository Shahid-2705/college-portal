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
  <meta charset="UTF-8" />
  <title>Admin Login - M.S.K College</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body
  style="background: linear-gradient(to right, #1e3c72, #2a5298); display:flex; align-items:center; justify-content:center; min-height:100vh;">
  <div class="bg-white p-4 rounded shadow" style="max-width:400px; width:100%;">
    <h4 class="mb-3 text-center text-primary">Admin Login</h4>
    <form method="POST" action="check_login.php">
      <input type="hidden" name="role" value="admin">
      <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button class="btn btn-dark w-100">Login</button>
    </form>
  </div>
</body>

</html>