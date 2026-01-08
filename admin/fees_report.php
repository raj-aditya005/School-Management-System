<?php
session_start();
include "../config/db.php";
if ($_SESSION['role'] != 'admin') header("Location: ../index.php");

$where = "1";
if (!empty($_GET['status'])) {
  $status = $_GET['status'];
  $where .= " AND f.status='$status'";
}
if (!empty($_GET['month'])) {
  $month = $_GET['month'];
  $where .= " AND f.month='$month'";
}
if (!empty($_GET['year'])) {
  $year = $_GET['year'];
  $where .= " AND f.year='$year'";
}

$fees = mysqli_query(
  $conn,
  "SELECT f.*, s.name, s.class
   FROM fees f
   JOIN students s ON s.id=f.student_id
   WHERE $where
   ORDER BY f.year DESC"
);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Fees Report</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include "header.php"; ?>
<?php include "sidebar.php"; ?>
<div class="container-fluid mt-4 pt-3">
<h4>Fees Report</h4>

<form class="row g-2 mb-3" method="GET">
  <div class="col-md-3">
    <select name="status" class="form-select">
      <option value="">All Status</option>
      <option value="Paid">Paid</option>
      <option value="Due">Due</option>
    </select>
  </div>
  <div class="col-md-3">
    <input name="month" class="form-control" placeholder="Month (Jan)">
  </div>
  <div class="col-md-2">
    <input name="year" type="number" class="form-control" placeholder="Year">
  </div>
  <div class="col-md-2">
    <button class="btn btn-secondary">Filter</button>
  </div>
</form>

<div class="table-responsive">
<table class="table table-bordered">
<tr>
  <th>Student</th><th>Class</th><th>Month</th><th>Year</th>
  <th>Amount</th><th>Status</th>
</tr>
<?php while($f=mysqli_fetch_assoc($fees)){ ?>
<tr>
  <td><?= $f['name'] ?></td>
  <td><?= $f['class'] ?></td>
  <td><?= $f['month'] ?></td>
  <td><?= $f['year'] ?></td>
  <td><?= $f['amount'] ?></td>
  <td><?= $f['status'] ?></td>
</tr>
<?php } ?>
</table>
</div>

</div></div>
</body>
</html>
