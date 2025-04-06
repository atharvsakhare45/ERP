<?php
include("db_config.php");

$sql = "SELECT * FROM feedback";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Student Feedback</title>
    <link rel="stylesheet" href="feedback.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 20px;
        }

        .feedback-container {
            max-width: 900px;
            margin: auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            padding: 30px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .feedback-table {
            width: 100%;
            border-collapse: collapse;
        }

        .feedback-table th, .feedback-table td {
            border: 1px solid #ccc;
            padding: 12px 15px;
            text-align: left;
        }

        .feedback-table th {
            background-color: #007bff;
            color: white;
        }

        .feedback-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .feedback-table tr:hover {
            background-color: #e6f7ff;
        }
    </style>
</head>
<body>
    <div class="feedback-container">
        <h2>Student Feedback</h2>
        <table class="feedback-table">
            <tr>
                <th>Student PRN</th>
                <th>Course Name</th>
                <th>Message</th>
            </tr>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['Student_PRN']) ?></td>
                    <td><?= htmlspecialchars($row['Course_Name']) ?></td>
                    <td><?= nl2br(htmlspecialchars($row['Message'])) ?></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" style="text-align: center;">No feedback available.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>
