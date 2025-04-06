<?php
include("db_config.php");
$sql = "SELECT * FROM enrollment";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>All Enrollments</title>
  <link rel="stylesheet" href="enrollment.css">
</head>
<body>
  <div class="container">
    <h1>All Enrollments</h1>
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
  </div>
</body>
</html>

