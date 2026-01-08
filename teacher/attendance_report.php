<?php
session_start();
include "../config/db.php";

if ($_SESSION['role'] != 'teacher') {
  header("Location: ../index.php");
}

$username = $_SESSION['username'];

// teacher class
$q = mysqli_query($conn, "SELECT class FROM teachers WHERE username='$username'");
$teacher = mysqli_fetch_assoc($q);
if (!$teacher || empty($teacher['class'])) {
  die("Class not assigned to this teacher.");
}
$class = trim(strtoupper($teacher['class']));

$records = [];
if (isset($_GET['date'])) {
  $date = $_GET['date'];
  $records = mysqli_query(
  $conn,
  "SELECT 
     s.id AS student_id,
     s.name,
     s.class,
     a.date,
     a.status
   FROM attendance a
   JOIN students s ON s.id = a.student_id
   WHERE a.date='$date'"
);

}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Attendance Report</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-primary mb-4">
  <div class="container-fluid">
    <span class="navbar-brand">Teacher Panel</span>
    <a href="dashboard.php" class="btn btn-light btn-sm">⬅ Dashboard</a>
  </div>
</nav>

<div class="container">
  <h4>Attendance Report (Class <?= $class ?>)</h4>

  <form method="GET" class="row g-2 mb-3">
    <div class="col-md-4">
      <input type="date" name="date" class="form-control" required>
    </div>
    <div class="col-md-2">
      <button class="btn btn-secondary">View</button>
    </div>
  </form>

  <?php if (!empty($records)) { ?>
  <div class="table-responsive">
    <table class="table table-bordered">
      <tr>
        <th>Name</th>
        <th>Date</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
      <?php while($r = mysqli_fetch_assoc($records)) { ?>
      <tr>
        <td><?= $r['name'] ?></td>
        <td><?= $r['date'] ?></td>
        <td><?= $r['status'] ?></td>
        <td>
  <a href="edit_attendance.php?sid=<?= $r['student_id'] ?>&date=<?= $r['date'] ?>"
     class="btn btn-sm btn-warning">
    Edit
  </a>
</td>

      </tr>
      <?php } ?>
    </table>
  </div>
  <?php } ?>
</div>

</body>
</html>
