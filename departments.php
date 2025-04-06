<?php
include("db_config.php");

$sql = "SELECT * FROM department";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department List</title>
    <link rel="stylesheet" href="departments.css">
</head>
<body>
    <div class="department-container">
        <h2>Department List</h2>
        <table class="department-table">
            <tr>
                <th>Department ID</th>
                <th>Department Name</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['Dept_ID']); ?></td>
                <td><?php echo htmlspecialchars($row['Dept_Name']); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>

