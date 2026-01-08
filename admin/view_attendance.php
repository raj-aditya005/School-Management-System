<?php
session_start();
include "../config/db.php";
if ($_SESSION['role'] != 'admin') {
  header("Location: ../index.php");
}

include "header.php";
include "sidebar.php";

$records = [];
if (isset($_GET['date'])) {
  $date = $_GET['date'];
  $records = mysqli_query(
    $conn,
    "SELECT students.name, students.class, attendance.status
     FROM attendance
     JOIN students ON attendance.student_id = students.id
     WHERE attendance.date='$date'"
  );
}
?>
<div class="container-fluid mt-4 pt-3">
<h4>View Attendance</h4>

<form method="GET" class="mb-3">
  <label>Select Date</label>
  <input type="date" name="date" class="form-control" required>
  <button class="btn btn-secondary mt-2">View</button>
</form>

<?php if (!empty($records)) { ?>
<div class="table-responsive">
  <table class="table table-bordered">
    <tr>
      <th>Name</th>
      <th>Class</th>
      <th>Status</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($records)) { ?>
    <tr>
      <td><?= $row['name'] ?></td>
      <td><?= $row['class'] ?></td>
      <td><?= $row['status'] ?></td>
    </tr>
    <?php } ?>
  </table>
</div>
<?php } ?>

</div></div>
</body>
</html>
