<?php
include "../config/db.php";
$id = $_GET['id'];

$q = mysqli_query(
  $conn,
  "SELECT f.*, s.name, s.class
   FROM fees f JOIN students s ON s.id=f.student_id
   WHERE f.id='$id'"
);
$r = mysqli_fetch_assoc($q);
?>
<!DOCTYPE html>
<html>
<head>
<title>Fees Receipt</title>
<style>
body{font-family:Arial}
.receipt{width:400px;margin:auto;border:1px solid #000;padding:20px}
</style>
</head>
<body onload="window.print()">

<div class="receipt">
<h3 align="center">School Fees Receipt</h3>
<p><b>Name:</b> <?= $r['name'] ?></p>
<p><b>Class:</b> <?= $r['class'] ?></p>
<p><b>Month:</b> <?= $r['month'] ?> <?= $r['year'] ?></p>
<p><b>Amount:</b> ₹<?= $r['amount'] ?></p>
<p><b>Status:</b> <?= $r['status'] ?></p>
<p><b>Paid On:</b> <?= $r['paid_on'] ?></p>
</div>

</body>
</html>
