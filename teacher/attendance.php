
<?php
session_start();
include "../config/db.php";


if ($_SESSION['role'] != 'teacher') {
  header("Location: ../index.php");
}

// Assume teacher username == teachers.name (simple approach)
if (!isset($_SESSION['username'])) {
  header("Location: ../index.php");
  exit;
}

$username = $_SESSION['username'];


$q = mysqli_query(
  $conn,
  "SELECT class FROM teachers WHERE username='$username'"
);

$teacher = mysqli_fetch_assoc($q);

if (!$teacher || empty($teacher['class'])) {
  die("Class not assigned to this teacher. Contact admin.");
}

$class = trim(strtoupper($teacher['class']));


// Get students of that class
$students = mysqli_query($conn, "SELECT * FROM students WHERE class='$class'");
if (!$students) {
  die("Students Query Failed: " . mysqli_error($conn));
}

// echo "Rows Found = " . mysqli_num_rows($students);
// exit;


// Save attendance
if (isset($_POST['save'])) {

  // ❗ status exist hi nahi karta
  if (!isset($_POST['status']) || !is_array($_POST['status'])) {
    $msg = "<div class='alert alert-danger'>
              Please mark attendance for at least one student.
            </div>";
  } else {

    $date = $_POST['date'];
    $alreadyMarked = false;
    $saved = false;

    foreach ($_POST['status'] as $student_id => $status) {

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
           VALUES ('$student_id','$date','$status')"
        );
        $saved = true;
      }
    }

    if ($saved && $alreadyMarked) {
      $msg = "<div class='alert alert-warning'>
                Some students already had attendance. Others were saved.
              </div>";
    } elseif ($saved) {
      $msg = "<div class='alert alert-success'>
                Attendance saved successfully.
              </div>";
    } else {
      $msg = "<div class='alert alert-danger'>
                Attendance already marked for all students.
              </div>";
    }
  }
}



?>

<!-- <nav class="navbar navbar-dark bg-primary mb-4">
  <div class="container-fluid">
    <span class="navbar-brand">Teacher Panel</span>

    <div>
      <a href="dashboard.php" class="btn btn-light btn-sm me-2">
        ⬅ Dashboard
      </a>
      <a href="../logout.php" class="btn btn-danger btn-sm">
        Logout
      </a>
    </div>
  </div>
</nav> -->


<!DOCTYPE html>
<html>
<head>
  <title>Teacher Attendance</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
  <!-- <h4>Class <?= $class ?> Attendance</h4> -->

  <div class="d-flex justify-content-between align-items-center mb-3">
  <h4>Class <?= $class ?> Attendance</h4>

  <a href="dashboard.php" class="btn btn-secondary">
    ⬅ Back to Dashboard
  </a>
</div>
 <?= $msg ?? '' ?>
  <form method="POST">
    <input type="date" name="date" class="form-control mb-3" required>

    <div class="table-responsive">
      <table class="table table-bordered">
        <tr>
          <th>Name</th>
          <th>Status</th>
        </tr>

        <?php while($s = mysqli_fetch_assoc($students)) { ?>
        <tr>
          <td><?= $s['name'] ?></td>
          <td>
            <select name="status[<?= $s['id'] ?>]" class="form-select">
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
</div>

</body>
</html>
