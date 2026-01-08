<?php
session_start();
include "../config/db.php";
if ($_SESSION['role'] != 'admin') header("Location: ../index.php");

// ADD / UPDATE FEES
if (isset($_POST['save'])) {
  $student_id = $_POST['student_id'];
  $month = $_POST['month'];
  $year = $_POST['year'];
  $amount = $_POST['amount'];
  $status = $_POST['status'];

  // duplicate check (student + month + year)
  $check = mysqli_query(
    $conn,
    "SELECT * FROM fees 
     WHERE student_id='$student_id' AND month='$month' AND year='$year'"
  );

  if (mysqli_num_rows($check) > 0) {
    // update
    mysqli_query(
      $conn,
      "UPDATE fees 
       SET amount='$amount', status='$status', 
           paid_on = IF('$status'='Paid', CURDATE(), NULL)
       WHERE student_id='$student_id' AND month='$month' AND year='$year'"
    );
    $msg = "<div class='alert alert-warning'>Fees updated</div>";
  } else {
    // insert
    mysqli_query(
      $conn,
      "INSERT INTO fees (student_id, month, year, amount, status, paid_on)
       VALUES ('$student_id','$month','$year','$amount','$status',
               IF('$status'='Paid', CURDATE(), NULL))"
    );
    $msg = "<div class='alert alert-success'>Fees added</div>";
  }
}

// FETCH DATA
$students = mysqli_query($conn, "SELECT id, name, class FROM students");
$fees = mysqli_query(
  $conn,
  "SELECT f.*, s.name, s.class
   FROM fees f
   JOIN students s ON s.id=f.student_id
   ORDER BY year DESC, month DESC"
);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Fees Management</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include "header.php"; ?>
<?php include "sidebar.php"; ?>
<div class="container-fluid mt-4 pt-3">
<h4>Fees Management</h4>
<?= $msg ?? '' ?>

<div class="row">
  <!-- ADD FEES -->
  <div class="col-md-4">
    <form method="POST">
      <select name="student_id" class="form-select mb-2" required>
        <option value="">Select Student</option>
        <?php while($s=mysqli_fetch_assoc($students)){ ?>
          <option value="<?= $s['id'] ?>">
            <?= $s['name'] ?> (<?= $s['class'] ?>)
          </option>
        <?php } ?>
      </select>

      <input name="month" class="form-control mb-2" placeholder="Month (e.g. Jan)" required>
      <input name="year" type="number" class="form-control mb-2" placeholder="Year" required>
      <input name="amount" type="number" class="form-control mb-2" placeholder="Amount" required>

      <select name="status" class="form-select mb-2">
        <option value="Due">Due</option>
        <option value="Paid">Paid</option>
      </select>

      <button class="btn btn-primary w-100" name="save">Save Fees</button>
    </form>
  </div>

  <!-- FEES LIST -->
  <div class="col-md-8">
    <div class="table-responsive">
      <table class="table table-bordered">
        <tr>
          <th>Student</th>
          <th>Class</th>
          <th>Month</th>
          <th>Year</th>
          <th>Amount</th>
          <th>Status</th>
          <th>Paid On</th>
          <th>Receipt</th>
        </tr>
        <?php while($f=mysqli_fetch_assoc($fees)){ ?>
        <tr>
          <td><?= $f['name'] ?></td>
          <td><?= $f['class'] ?></td>
          <td><?= $f['month'] ?></td>
          <td><?= $f['year'] ?></td>
          <td><?= $f['amount'] ?></td>
          <td>
            <span class="badge <?= $f['status']=='Paid'?'bg-success':'bg-danger' ?>">
              <?= $f['status'] ?>
            </span>
          </td>
          <td><?= $f['paid_on'] ?? '-' ?></td>
          <td>
    <?php if($f['status']=='Paid'){ ?>
      <a href="fees_receipt.php?id=<?= $f['id'] ?>" 
         class="btn btn-sm btn-info">
        Receipt
      </a>
    <?php } else { ?>
      -
    <?php } ?>
  </td>
        </tr>
        <?php } ?>
      </table>
    </div>
  </div>
</div>

</div></div>
</body>
</html>
