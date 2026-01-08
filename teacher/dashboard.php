
<?php
session_start();
include "../config/db.php";

if ($_SESSION['role'] != 'teacher') {
  header("Location: ../index.php");
  exit;
}

if (!isset($_SESSION['username'])) {
  header("Location: ../index.php");
  exit;
}

$username = $_SESSION['username'];

/* FETCH ASSIGNED CLASS */
$q = mysqli_query(
  $conn,
  "SELECT class FROM teachers WHERE username='$username'"
);

$teacher = mysqli_fetch_assoc($q);

$class = $teacher['class'] ?? null;

/* TOTAL STUDENTS OF CLASS */
$student_count = 0;
if ($class) {
  $res = mysqli_query(
    $conn,
    "SELECT id FROM students WHERE class='$class'"
  );
  $student_count = mysqli_num_rows($res);
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Teacher Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .action-card {
  transition: all 0.3s ease;
}

.action-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 12px 25px rgba(0,0,0,0.12);
  background: #99b8ffff;
}
</style>

</head>
<body>

<nav class="navbar navbar-dark bg-primary">
  <div class="container-fluid">
    <span class="navbar-brand">Teacher Panel</span>
    <a href="../logout.php" class="btn btn-light btn-sm">Logout</a>
  </div>
</nav>
<div class="container mt-4">
  <div class="p-4 rounded shadow-sm bg-light mb-4">
    <h4 class="mb-1">Welcome 👋</h4>
    <p class="text-muted mb-0">
      Manage your class attendance and reports easily.
    </p>
  </div>
<div class="row g-3 mb-4">

  <div class="col-md-4">
    <div class="card shadow-sm border-0 h-100">
      <div class="card-body">
        <h6 class="text-muted">Assigned Class</h6>
        <h3 class="fw-bold text-primary"><?= $class ?? 'N/A' ?></h3>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card shadow-sm border-0 h-100">
      <div class="card-body">
        <h6 class="text-muted">Total Students</h6>
        <h3 class="fw-bold text-success"><?= $student_count ?? 0 ?></h3>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card shadow-sm border-0 h-100">
      <div class="card-body">
        <h6 class="text-muted">Today</h6>
        <h3 class="fw-bold text-warning"><?= date('d M Y') ?></h3>
      </div>
    </div>
  </div>

</div>

<div class="row g-4">

  <div class="col-md-6">
    <a href="attendance.php" class="text-decoration-none">
      <div class="card h-100 shadow-sm action-card border-0">
        <div class="card-body text-center">
          <h5 class="text-success">📝 Mark Attendance</h5>
          <p class="text-muted">
            Mark daily attendance for your class
          </p>
        </div>
      </div>
    </a>
  </div>

  <div class="col-md-6">
    <a href="attendance_report.php" class="text-decoration-none">
      <div class="card h-100 shadow-sm action-card border-0">
        <div class="card-body text-center">
          <h5 class="text-primary">📊 Attendance Report</h5>
          <p class="text-muted">
            View past attendance records
          </p>
        </div>
      </div>
    </a>
  </div>

</div>

<div class="mt-4 text-center text-muted small">
  Tip 💡: Mark attendance daily to keep records accurate.
</div>

</body>
</html>
