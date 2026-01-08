<?php
session_start();
include "../config/db.php";
if ($_SESSION['role'] != 'admin') {
  header("Location: ../index.php");
}

// ADD STUDENT
if (isset($_POST['add'])) {
  $name  = $_POST['name'];
  $class = $_POST['class'];
  $email = $_POST['email'];

  mysqli_query($conn, "INSERT INTO students (name, class, email) VALUES ('$name','$class','$email')");
}

// DELETE STUDENT
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  mysqli_query($conn, "DELETE FROM students WHERE id=$id");
}

$students = mysqli_query($conn, "SELECT * FROM students");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Students</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
  <div class="container-fluid">
    <span class="navbar-brand">Student Management</span>
    <a href="dashboard.php" class="btn btn-light btn-sm">Back</a>
  </div>
</nav>

<div class="container mt-4">
  <div class="row">
    <!-- ADD FORM -->
    <div class="col-md-4">
      <h5>Add Student</h5>
      <form method="POST">
        <input class="form-control mb-2" name="name" placeholder="Name" required>
        <input class="form-control mb-2" name="class" placeholder="Class" required>
        <input class="form-control mb-2" name="email" placeholder="Email" required>
        <button class="btn btn-primary w-100" name="add">Add</button>
      </form>
    </div>

    <!-- STUDENT LIST -->
    <div class="col-md-8">
      <h5>Student List</h5>
      <div class="table-responsive">
        <table class="table table-bordered">
          <tr>
            <th>ID</th><th>Name</th><th>Class</th><th>Email</th><th>Action</th>
          </tr>
          <?php while($row = mysqli_fetch_assoc($students)) { ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['class'] ?></td>
            <td><?= $row['email'] ?></td>
            <td>
              <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
            </td>
          </tr>
          <?php } ?>
        </table>
      </div>
    </div>
  </div>
</div>

</body>
</html>
