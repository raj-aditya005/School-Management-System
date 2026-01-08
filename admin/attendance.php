<?php
session_start();
include "../config/db.php";

if ($_SESSION['role'] != 'admin') {
  header("Location: ../index.php");
}

include "header.php";
include "sidebar.php";

// Save attendance with duplicate check
if (isset($_POST['save'])) {
  $date = $_POST['date'];

  // check if attendance already exists for this date
  if (isset($_POST['save'])) {
  $date = $_POST['date'];
  $alreadyMarked = false;

  foreach ($_POST['status'] as $student_id => $status) {

    // student + date check
    $check = mysqli_query(
      $conn,
      "SELECT * FROM attendance 
       WHERE student_id='$student_id' AND date='$date'"
    );

    if (mysqli_num_rows($check) > 0) {
      $alreadyMarked = true;
    } else {
      mysqli_query(
        $conn,
        "INSERT INTO attendance (student_id, date, status)
         VALUES ('$student_id', '$date', '$status')"
      );
    }
  }

  if ($alreadyMarked) {
    echo "<div class='alert alert-warning'>
            Some students already had attendance for this date.
          </div>";
  } else {
    echo "<div class='alert alert-success'>
            Attendance saved successfully.
          </div>";
  }
}
}


// Fetch students
$students = mysqli_query($conn, "SELECT * FROM students");
?>
<div class="container-fluid mt-4 pt-3">
<h4>Mark Attendance</h4>

<form method="POST">
  <div class="mb-3">
    <label>Select Date</label>
    <input type="date" name="date" class="form-control" required>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Class</th>
        <th>Status</th>
      </tr>

      <?php while ($row = mysqli_fetch_assoc($students)) { ?>
      <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['name'] ?></td>
        <td><?= $row['class'] ?></td>
        <td>
          <select name="status[<?= $row['id'] ?>]" class="form-select" required>
            <option value="Present">Present</option>
            <option value="Absent">Absent</option>
          </select>
        </td>
      </tr>
      <?php } ?>
    </table>
  </div>

  <button class="btn btn-primary" name="save">Save Attendance</button>
</form>

</div></div>
</body>
</html>
