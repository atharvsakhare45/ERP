<?php
include("db_config.php");

$sql = "SELECT * FROM fees";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Student Fees</title>
  <link rel="stylesheet" href="fees.css">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f0f4f8;
      margin: 0;
      padding: 20px;
    }

    .fees-container {
      max-width: 900px;
      margin: auto;
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      color: #333;
      margin-bottom: 25px;
    }

    .fees-table {
      width: 100%;
      border-collapse: collapse;
    }

    .fees-table th, .fees-table td {
      padding: 12px 15px;
      border: 1px solid #ddd;
      text-align: center;
    }

    .fees-table th {
      background-color: #007bff;
      color: white;
    }

    .fees-table tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    .fees-table td {
      color: #444;
    }
  </style>
</head>
<body>
  <div class="fees-container">
    <h2>Student Fees Details</h2>
    <table class="fees-table">
      <tr>
        <th>Student PRN</th>
        <th>Course Name</th>
        <th>Amount</th>
        <th>Department ID</th>
      </tr>
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['Student_PRN']) ?></td>
            <td><?= htmlspecialchars($row['Course_Name']) ?></td>
            <td>₹<?= number_format($row['Amount'], 2) ?></td>
            <td><?= htmlspecialchars($row['Dept_ID']) ?></td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="4">No fee records found.</td></tr>
      <?php endif; ?>
    </table>
  </div>
</body>
</html>
