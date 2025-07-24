<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
  header("Location: ../login.php");
  exit();
}

include "../includes/db.php";
include "../includes/header.php";

if (isset($_POST['create'])) {
  $name = $conn->real_escape_string($_POST['name']);
  $email = $conn->real_escape_string($_POST['email']);
  $password = $conn->real_escape_string($_POST['password']);
  $role = $_POST['role'];

  // Check if user already exists
  $check = $conn->query("SELECT * FROM users WHERE email='$email'");
  if ($check->num_rows > 0) {
    echo "<div class='alert alert-warning'>User with this email already exists!</div>";
  } else {
    $sql = "INSERT INTO users (name, email, password, role) 
                VALUES ('$name', '$email', '$password', '$role')";
    if ($conn->query($sql)) {
      echo "<div class='alert alert-success'>User created successfully!</div>";
    } else {
      echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
    }
  }
}
?>

<h3>Create New User</h3>
<form method="POST" class="mt-3">
  <div class="mb-3">
    <label>Name</label>
    <input type="text" name="name" class="form-control" required />
  </div>
  <div class="mb-3">
    <label>Email</label>
    <input type="email" name="email" class="form-control" required />
  </div>
  <div class="mb-3">
    <label>Password</label>
    <input type="text" name="password" class="form-control" required />
  </div>
  <div class="mb-3">
    <label>Role</label>
    <select name="role" class="form-select" required>
      <option value="student">Student</option>
      <option value="admin">Admin</option>
    </select>
  </div>
  <button name="create" class="btn btn-primary">Create User</button>
  <a href="dashboard.php" class="btn btn-secondary">Back</a>
</form>

<?php include "../includes/footer.php"; ?>