<?php
session_start();

if (!isset($_SESSION['role'])) {
  header("Location: index.php");
}

if ($_SESSION['role'] == 'admin') {
  header("Location: admin/dashboard.php");
} elseif ($_SESSION['role'] == 'teacher') {
  header("Location: teacher/dashboard.php");
} else {
  header("Location: student/dashboard.php");
}
?>

