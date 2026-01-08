<?php
session_start();
include "../config/db.php";
if ($_SESSION['role'] != 'admin') header("Location: ../index.php");

$sid  = $_GET['sid'] ?? '';
$date = $_GET['date'] ?? '';

$q = mysqli_query($conn,
  "SELECT s.name, s.class, a.status
   FROM attendance a JOIN students s ON s.id=a.student_id
   WHERE a.student_id='$sid' AND a.date='$date'"
);
$row = mysqli_fetch_assoc($q);
if (!$row) die("Record not found");

if (isset($_POST['update'])) {
  $status = $_POST['status'];
  mysqli_query($conn,
    "UPDATE attendance SET status='$status'
     WHERE student_id='$sid' AND date='$date'"
  );
  header("Location: attendance_report.php?date=$date");
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Attendance</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include "header.php"; ?>
<?php include "sidebar.php"; ?>

<div class="container">
  <h4>Edit Attendance</h4>
  <p><b>Name:</b> <?= $row['name'] ?> | <b>Class:</b> <?= $row['class'] ?> | <b>Date:</b> <?= $date ?></p>

  <form method="POST" class="col-md-4">
    <select name="status" class="form-select mb-3">
      <option <?= $row['status']=='Present'?'selected':'' ?>>Present</option>
      <option <?= $row['status']=='Absent'?'selected':'' ?>>Absent</option>
    </select>
    <button class="btn btn-primary" name="update">Update</button>
    <a href="attendance_report.php?date=<?= $date ?>" class="btn btn-secondary ms-2">Cancel</a>
  </form>
</div>
</body>
</html>
