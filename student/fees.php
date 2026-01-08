<?php
session_start();
include "../config/db.php";
if ($_SESSION['role'] != 'student') header("Location: ../index.php");

$username = $_SESSION['username'];

// assume student username = students.name (simple mapping)
$s = mysqli_query($conn,"SELECT id,name,class FROM students WHERE name='$username'");
$student = mysqli_fetch_assoc($s);

$fees = mysqli_query(
  $conn,
  "SELECT * FROM fees WHERE student_id='{$student['id']}'
   ORDER BY year DESC"
);
?>
<!DOCTYPE html>
<html>
<head>
  <title>My Fees</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-success mb-4">
  <div class="container-fluid">
    <span class="navbar-brand">Student Panel</span>
    <a href="dashboard.php" class="btn btn-light btn-sm">Dashboard</a>
  </div>
</nav>

<div class="container">
<h4>My Fees History</h4>

<table class="table table-bordered">
<tr>
  <th>Month</th><th>Year</th><th>Amount</th><th>Status</th>
</tr>
<?php while($f=mysqli_fetch_assoc($fees)){ ?>
<tr>
  <td><?= $f['month'] ?></td>
  <td><?= $f['year'] ?></td>
  <td><?= $f['amount'] ?></td>
  <td><?= $f['status'] ?></td>
</tr>
<?php } ?>
</table>
</div>

</body>
</html>
