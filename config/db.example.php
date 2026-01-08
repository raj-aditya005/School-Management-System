<?php
$conn = mysqli_connect(
  "localhost",
  "DB_USER",
  "DB_PASSWORD",
  "DB_NAME"
);

if (!$conn) {
  die("Database connection failed");
}
