
<?php
include("db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_id = $_POST['course_id'];
    $course_name = $_POST['course_name'];
    $department = $_POST['department'];
    $credits = $_POST['credits'];

    // Validate credits is a number
    if (!is_numeric($credits) || $credits <= 0) {
        echo "<script>alert('Invalid credits value!'); window.history.back();</script>";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO courses (course_id, course_name, department, credits) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $course_id, $course_name, $department, $credits);

    if ($stmt->execute()) {
        echo "<script>alert('Course added successfully!'); window.location.href = 'add_course.php';</script>";
    } else {
        echo "<script>alert('Error adding course: " . $stmt->error . "'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Add Course</title>
  <link rel="stylesheet" href="add_course.css" />
</head>
<body>
  <div class="form-container">
    <h2>Add New Course</h2>
    <form method="POST" action="add_course.php">
      <input type="text" name="course_id" placeholder="Course ID" required>
      <input type="text" name="course_name" placeholder="Course Name" required>
      <input type="text" name="department" placeholder="Department" required>
      <input type="number" name="credits" placeholder="Credits" required>
      <button type="submit">Add Course</button>
    </form>
  </div>
</body>
</html>
    