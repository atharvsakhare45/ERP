<?php
include("db_config.php");

$search_result = null;
$no_results = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search = trim($_POST['course_id']);

    if (!empty($search)) {
        $search = "%$search%"; // For partial match
        $stmt = $conn->prepare("SELECT * FROM courses WHERE course_id LIKE ? OR course_name LIKE ?");
        $stmt->bind_param("ss", $search, $search);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $search_result = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $no_results = true;
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Search Course Results</title>
  <link rel="stylesheet" href="search_course.css" />
  <style>
    .result-table {
      width: 90%;
      margin: 30px auto;
      border-collapse: collapse;
    }

    .result-table th, .result-table td {
      padding: 12px;
      border: 1px solid #ccc;
      text-align: center;
    }

    .result-table th {
      background-color: #f0f0f0;
    }

    .no-result {
      text-align: center;
      margin-top: 20px;
      color: red;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Search Course</h2>
    <form method="POST" action="search_course.php">
      <input type="text" name="course_id" placeholder="Enter Course ID or Name">
      <button type="submit">Search</button>
    </form>
  </div>

  <?php if ($search_result): ?>
    <table class="result-table">
      <thead>
        <tr>
          <th>Course ID</th>
          <th>Course Name</th>
          <th>Department</th>
          <th>Credits</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($search_result as $course): ?>
          <tr>
            <td><?= htmlspecialchars($course['course_id']) ?></td>
            <td><?= htmlspecialchars($course['course_name']) ?></td>
            <td><?= htmlspecialchars($course['department']) ?></td>
            <td><?= htmlspecialchars($course['credits']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php elseif ($no_results): ?>
    <div class="no-result">No course found for the given input.</div>
  <?php endif; ?>
</body>
</html>
