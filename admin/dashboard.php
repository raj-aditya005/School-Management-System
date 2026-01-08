<?php
include "../config/db.php";

$students = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS total FROM students"))['total'];
$teachers = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) AS total FROM teachers"))['total'];
$today = date('Y-m-d');
$attendance_today = mysqli_fetch_assoc(
  mysqli_query($conn,"SELECT COUNT(*) AS total FROM attendance WHERE date='$today'")
)['total'];

$due_fees = mysqli_fetch_assoc(
  mysqli_query($conn,"SELECT SUM(amount) AS total FROM fees WHERE status='Due'")
)['total'];

$absent_today = mysqli_fetch_assoc(
  mysqli_query(
    $conn,
    "SELECT COUNT(*) AS total FROM attendance 
     WHERE date='$today' AND status='Absent'"
  )
)['total'];

$attendance_done = $attendance_today > 0;

$total_students = $students;
$attendance_percent = $total_students > 0
  ? round(($attendance_today / $total_students) * 100)
  : 0;

?>

<?php
session_start();
if ($_SESSION['role'] != 'admin') {
  header("Location: ../index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <style>
body {
  background-color: #f4f6f9;
  font-family: 'Segoe UI', system-ui, sans-serif;
}
:root {
  --primary: #4f46e5;
}
.dashboard-card {
  border: none;
  border-radius: 14px;
  color: #fff;
  padding: 20px;
  transition: all 0.3s ease;
  box-shadow: 0 10px 25px rgba(0,0,0,0.08);
  border-left: 6px solid var(--primary);
}
.dashboard-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 18px 40px rgba(0,0,0,0.15);
}

/* Gradients */
.gradient-blue {
  background: linear-gradient(135deg, #9088fcff, #7679ffff);
}
.action-card {
  border-radius: 14px;
  padding: 30px;
  text-align: center;
  font-weight: 600;
  font-size: 18px;
  transition: 0.3s;
  background: #ffffff;
  box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}
.action-card:hover {
  transform: translateY(-5px);
  background: #7679ffff;
  color: #fff;
}



</style>

  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
.progress-ring {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  background:
    conic-gradient(
      var(--primary) calc(var(--value) * 1%),
      #e5e7eb 0
    );
  display: flex;
  align-items: center;
  justify-content: center;
  margin: auto;
}
.progress-ring span {
  background: #fff;
  border-radius: 50%;
  width: 80px;
  height: 80px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 600;
}
body.dark .progress-ring span {
  background: #1e293b;
}
</style>

</head>
<body>

<nav class="navbar navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <span class="navbar-brand">Admin Panel</span>
    <a href="../logout.php" class="btn btn-danger btn-sm">Logout</a>
  </div>
</nav>
<div class="container-fluid mt-5 pt-4">
<h4 class=" fw-semibold text-secondary">
    👋 Welcome back, Admin
  </h4>

<div class="row mt-3 pt-2">

  <div class="col-md-3">
    <div class="card dashboard-card gradient-blue"
         data-bs-toggle="tooltip"
         title="View all students">
      <div class="card-body">
        <h6>Total Students</h6>
        <h2 class="count"><?= $students ?></h2>

      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card dashboard-card gradient-blue"
         data-bs-toggle="tooltip"
         title="View all teachers">
      <div class="card-body">
        <h6>Total Teachers</h6>
        <h2 class="count"><?= $teachers ?></h2>

      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card dashboard-card gradient-blue"
         data-bs-toggle="tooltip"
         title="View attendance">
      <div class="card-body">
        <h6>Today's Attendance</h6>
        <h2 class="count"><?= $attendance_today ?></h2>

      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card dashboard-card gradient-blue"
         data-bs-toggle="tooltip"
         title="View pending">
      <div class="card-body">
        <h6>Pending Fees (₹)</h6>
        <h2 class="count"><?= $due_fees ?? 0 ?></h2>

      </div>
    </div>
  </div>

</div>
<div class="card mb-4 shadow-sm">
  <div class="card-body">
    <h6 class="fw-semibold mb-2">🧠 Smart Insights</h6>

    <?php if(!$attendance_done){ ?>
      <div class="text-warning">⚠️ Attendance not marked today</div>
    <?php } ?>

    <?php if($absent_today > 0){ ?>
      <div class="text-danger">
        <?= $absent_today ?> students absent today
      </div>
    <?php } ?>

    <?php if(($due_fees ?? 0) > 0){ ?>
      <div class="text-primary">
        ₹<?= $due_fees ?> fees pending
      </div>
    <?php } ?>
  </div>
</div>


<div class="container mt-5 pt-4">
  <div class="row g-3">
<div class="col-md-4">
  <a href="students.php" class="text-decoration-none text-dark">
    <div class="action-card">👨‍🎓 Students</div>
  </a>
</div>

<div class="col-md-4">
  <a href="teachers.php" class="text-decoration-none text-dark">
    <div class="action-card">👨‍🏫 Teachers</div>
  </a>
</div>

<div class="col-md-4">
  <a href="attendance.php" class="text-decoration-none text-dark">
    <div class="action-card">📅 Attendance</div>
  </a>
</div>

<div class="card mb-4 shadow-sm">
  <div class="card-body text-center">
    <h6 class="fw-semibold mb-3">📊 Today’s Progress</h6>

    <div class="progress-ring" style="--value:<?= $attendance_percent ?>">
      <span><?= $attendance_percent ?>%</span>
    </div>

    <div class="text-muted mt-2">Attendance Completion</div>
  </div>
</div>

    </div>
  </a>
</div>

  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
var tooltipTriggerList = [].slice.call(
  document.querySelectorAll('[data-bs-toggle="tooltip"]')
);
tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl);
});
</script>
<script>
document.querySelectorAll('.count').forEach(el => {
  let target = +el.innerText;
  let count = 0;
  let step = target / 30;

  let interval = setInterval(() => {
    count += step;
    if (count >= target) {
      el.innerText = target;
      clearInterval(interval);
    } else {
      el.innerText = Math.ceil(count);
    }
  }, 30);
});
</script>
<script>
window.onload = () => {
  document.getElementById('skeleton').style.display = 'none';
  document.getElementById('realContent').style.display = 'block';
};
</script>

<?php include "../assets/ai-widget.php"; ?>


</body>
</html>
