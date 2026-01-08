<?php
session_start();
include "../config/db.php";
if ($_SESSION['role'] != 'admin') {
  header("Location: ../index.php");
}
include "header.php";
include "sidebar.php";

// ADD TEACHER
if (isset($_POST['add'])) {
  $name = $_POST['name'];
  $subject = $_POST['subject'];
  $email = $_POST['email'];
  mysqli_query($conn, "INSERT INTO teachers (name, subject, email) VALUES ('$name','$subject','$email')");
}

// DELETE TEACHER
if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  mysqli_query($conn, "DELETE FROM teachers WHERE id=$id");
}

$teachers = mysqli_query($conn, "SELECT * FROM teachers");
?>
<div class="container-fluid mt-4 pt-3">
<h4>Teacher Management</h4>

<div class="row">
  <div class="col-md-4">
    <form method="POST">
      <input class="form-control mb-2" name="name" placeholder="Name" required>
      <input class="form-control mb-2" name="subject" placeholder="Subject" required>
      <input class="form-control mb-2" name="email" placeholder="Email" required>
      <button class="btn btn-success w-100" name="add">Add Teacher</button>
    </form>
  </div>

  <div class="col-md-8">
    <table class="table table-bordered">
      <tr>
        <th>ID</th><th>Name</th><th>Subject</th><th>Email</th><th>Action</th>
      </tr>
      <?php while($row = mysqli_fetch_assoc($teachers)) { ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['name'] ?></td>
        <td><?= $row['subject'] ?></td>
        <td><?= $row['email'] ?></td>
        <td>
          <a href="?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
        </td>
      </tr>
      <?php } ?>
    </table>
  </div>
</div>

</div> <!-- sidebar end -->
</div>
</body>
</html>
