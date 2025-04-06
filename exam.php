<?php
include("db_config.php");

$sql = "SELECT * FROM exam_details";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Exam Details</title>
  <link rel="stylesheet" href="exam.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f5f5f5;
      margin: 0;
      padding: 20px;
    }

    .container {
      max-width: 800px;
      margin: auto;
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    }

    h1 {
      text-align: center;
      color: #333;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    th, td {
      padding: 12px;
      border-bottom: 1px solid #ddd;
      text-align: center;
    }

    th {
      background-color: #007bff;
      color: white;
    }

    tr:hover {
      background-color: #f0f8ff;
    }

    .no-data {
      text-align: center;
      color: gray;
      font-style: italic;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Exam Details</h1>
    <table>
      <thead>
        <tr>
          <th>Course Name</th>
          <th>Exam Date</th>
          <th>Exam Time</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if ($result && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['course_name']) . "</td>
                    <td>" . htmlspecialchars($row['exam_date']) . "</td>
                    <td>" . htmlspecialchars($row['exam_time']) . "</td>
                  </tr>";
          }
        } else {
          echo "<tr><td colspan='3' class='no-data'>No exams available</td></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</body>
</html>


