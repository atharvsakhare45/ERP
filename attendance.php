<?php
include("db_config.php");

$sql = "SELECT * FROM attendance";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Student Attendance</title>
    <link rel="stylesheet" href="attendance.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f9;
            padding: 20px;
        }

        .attendance-container {
            max-width: 900px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        .attendance-table {
            width: 100%;
            border-collapse: collapse;
        }

        .attendance-table th, .attendance-table td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .attendance-table th {
            background-color: #007bff;
            color: white;
        }

        .attendance-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .present {
            color: green;
            font-weight: bold;
        }

        .absent {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="attendance-container">
        <h2>Student Attendance</h2>
        <table class="attendance-table">
            <tr>
                <th>Student PRN</th>
                <th>Course Name</th>
                <th>Status</th>
            </tr>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['Student_PRN']) ?></td>
                        <td><?= htmlspecialchars($row['Course_Name']) ?></td>
                        <td class="<?= strtolower($row['Status']) ?>">
                            <?= htmlspecialchars($row['Status']) ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="3" style="text-align:center;">No attendance data found.</td></tr>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>
