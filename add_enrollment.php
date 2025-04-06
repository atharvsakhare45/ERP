<?php
include("db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_prn = $_POST['student_prn'];
    $student_name = $_POST['student_name'];
    $course_id = $_POST['course_id'];
    $course_name = $_POST['course_name'];

    $sql = "INSERT INTO enrollment (Student_PRN, Student_Name, Course_ID, Course_Name) 
            VALUES ('$student_prn', '$student_name', '$course_id', '$course_name')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Enrollment Added Successfully'); window.location.href='enrollment.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Enrollment</title>
  <link rel="stylesheet" href="enrollment.css">
</head>
<body>
  <div class="container">
    <h1>Add Enrollment</h1>
    <form method="POST">
      <input type="text" name="student_prn" placeholder="Student PRN" required>
      <input type="text" name="student_name" placeholder="Student Name" required>
      <input type="text" name="course_id" placeholder="Course ID" required>
      <input type="text" name="course_name" placeholder="Course Name" required>
      <button type="submit">Enroll Student</button>
    </form>
  </div>
</body>
</html>

