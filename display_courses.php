<?php
include("db_config.php");

$result = $conn->query("SELECT * FROM courses");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Display Courses</title>
  <link rel="stylesheet" href="display_courses.css" />
  <style>
    .table-container {
      width: 90%;
      margin: 40px auto;
      font-family: Arial, sans-serif;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      padding: 12px;
      border: 1px solid #ccc;
      text-align: center;
    }

    th {
      background-color: #f5f5f5;
    }

    .no-data {
      text-align: center;
      color: gray;
      font-style: italic;
      padding: 20px;
    }
  </style>
</head>
<body>
  <div class="table-container">
    <h2>All Courses</h2>
    <table>
      <thead>
        <tr>
          <th>Course ID</th>
          <th>Name</th>
          <th>Department</th>
          <th>Credits</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['course_id']) ?></td>
              <td><?= htmlspecialchars($row['course_name']) ?></td>
              <td><?= htmlspecialchars($row['department']) ?></td>
              <td><?= htmlspecialchars($row['credits']) ?></td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="4" class="no-data">No courses found in the database.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>

