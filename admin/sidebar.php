<div class="d-flex">
  <div class="bg-light p-3" style="width:200px; min-height:100vh;">
    <!-- <ul class="nav flex-column">
      <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
      <li class="nav-item"><a class="nav-link" href="students.php">Students</a></li>
      <li class="nav-item"><a class="nav-link" href="teachers.php">Teachers</a></li> -->

<div class="sidebar">      
<ul class="nav flex-column">  
      <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
      <li class="nav-item"><a class="nav-link" href="students.php">Students</a></li>
      <li class="nav-item"><a class="nav-link" href="teachers.php">Teachers</a></li>       
<li class="nav-item">
  <a class="nav-link" href="attendance.php">Mark Attendance</a>
</li>
<li class="nav-item">
  <a class="nav-link" href="view_attendance.php">View Attendance</a>
</li>
<li class="nav-item">
  <a class="nav-link" href="attendance_report.php">Attendance Report</a>
</li>
<li class="nav-item">
  <a class="nav-link" href="fees.php">Fees Management</a>
</li>
<li class="nav-item">
  <a class="nav-link" href="fees_report.php">Fees Report</a>
</li>

</ul>
</div>
<style>
.sidebar {
  width: 210px;
  height: calc(100vh - 56px); /* full height minus header */
  background: #212529;
  position: fixed;
  top: 56px;       /* header height */
  left: 0;
  overflow-y: auto; /* sidebar scroll if items more */
}

.sidebar a {
  color: #adb5bd;
  display: block;
  padding: 12px 20px;
  text-decoration: none;
}

.sidebar a:hover,
.sidebar a.active {
  background: #0d6efd;
  color: #fff;
}
</style>

    </ul>
  </div>
  <div class="p-4 flex-fill">


