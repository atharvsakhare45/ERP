<?php
include("db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_prn = $_POST['student_prn'];
    $course_id = $_POST['course_id'];

    $sql = "DELETE FROM enrollment WHERE Student_PRN='$student_prn' AND Course_ID='$course_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Enrollment Deleted'); window.location.href='enrollment.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Delete Enrollment</title>
  <link rel="stylesheet" href="enrollment.css">
</head>
<body>
  <div class="container">
    <h1>Delete Enrollment</h1>
    <form method="POST">
      <input type="text" name="student_prn" placeholder="Student PRN" required>
      <input type="text" name="course_id" placeholder="Course ID" required>
      <button type="submit">Delete Enrollment</button>
    </form>
  </div>
</body>
</html>

