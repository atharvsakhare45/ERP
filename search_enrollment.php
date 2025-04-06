<?php
include("db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_prn = $_POST['student_prn'];
    $sql = "SELECT * FROM enrollment WHERE Student_PRN='$student_prn'";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Search Enrollment</title>
  <link rel="stylesheet" href="enrollment.css">
</head>
<body>
  <div class="container">
    <h1>Search Enrollment</h1>
    <form method="POST">
      <input type="text" name="student_prn" placeholder="Enter Student PRN" required>
      <button type="submit">Search</button>
    </form>
    <br>
    <?php if (isset($result) && $result->num_rows > 0): ?>
      <table border="1">
        <tr>
          <th>Student PRN</th>
          <th>Student Name</th>
          <th>Course ID</th>
          <th>Course Name</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?php echo $row['Student_PRN']; ?></td>
          <td><?php echo $row['Student_Name']; ?></td>
          <td><?php echo $row['Course_ID']; ?></td>
          <td><?php echo $row['Course_Name']; ?></td>
        </tr>
        <?php endwhile; ?>
      </table>
    <?php endif; ?>
  </div>
</body>
</html>

