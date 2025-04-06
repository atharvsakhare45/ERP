<?php
include("db_config.php");

$sql = "SELECT * FROM faculty_salary";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Salary</title>
    <link rel="stylesheet" href="faculty_salary.css">
</head>
<body>
    <div class="salary-container">
        <h2>Faculty Salary Details</h2>
        <table class="salary-table">
            <tr>
                <th>Faculty ID</th>
                <th>Amount</th>
                <th>Department</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['Faculty_ID']); ?></td>
                <td>₹<?php echo number_format($row['Amount']); ?></td>
                <td><?php echo htmlspecialchars($row['Department']); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>


