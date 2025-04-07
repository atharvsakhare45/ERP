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
    <title>Faculty Salary Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        :root {
            --primary: #5e35b1;
            --secondary: #3949ab;
            --accent: #7c4dff;
            --light: #f5f3ff;
            --dark: #1a237e;
            --success: #26a69a;
            --danger: #ef5350;
            --warning: #ffa726;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
            min-height: 100vh;
            padding: 2rem;
            animation: gradientBG 15s ease infinite;
            background-size: 300% 300%;
        }
        
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .salary-container {
            max-width: 1200px;
            width: 100%;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            box-shadow: var(--shadow);
            overflow: hidden;
            padding: 2.5rem;
            animation: fadeInUp 0.8s ease-out;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        h2 {
            text-align: center;
            color: var(--dark);
            margin-bottom: 2rem;
            font-size: 2.2rem;
            font-weight: 700;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }
        
        h2::after {
            content: '';
            position: absolute;
            bottom: -0.75rem;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: var(--accent);
            border-radius: 2px;
            animation: expandLine 1s ease-out;
        }
        
        @keyframes expandLine {
            from { width: 0; }
            to { width: 100px; }
        }
        
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
            animation: fadeIn 1s ease-out 0.3s both;
        }
        
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: var(--shadow);
            transition: var(--transition);
            border-left: 4px solid var(--accent);
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .stat-card h3 {
            color: var(--dark);
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .stat-card p {
            color: var(--primary);
            font-size: 1.8rem;
            font-weight: 700;
        }
        
        .table-container {
            overflow-x: auto;
            border-radius: 12px;
            box-shadow: var(--shadow);
            animation: slideUp 0.8s ease-out 0.4s both;
            background: white;
        }
        
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .salary-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        
        .salary-table thead {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            position: sticky;
            top: 0;
        }
        
        .salary-table th {
            padding: 1rem 1.5rem;
            text-align: left;
            font-weight: 600;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .salary-table tbody tr {
            transition: var(--transition);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .salary-table tbody tr:last-child {
            border-bottom: none;
        }
        
        .salary-table tbody tr:hover {
            background-color: rgba(94, 53, 177, 0.05);
            transform: translateX(5px);
        }
        
        .salary-table td {
            padding: 1.2rem 1.5rem;
            color: #555;
            font-weight: 500;
        }
        
        .salary-table td:first-child {
            font-weight: 600;
            color: var(--primary);
        }
        
        .amount-cell {
            font-weight: 700;
            color: #2e7d32;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .department-cell {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .department-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            background: rgba(94, 53, 177, 0.1);
            color: var(--primary);
        }
        
        .no-data {
            text-align: center;
            padding: 3rem;
            color: #777;
            font-style: italic;
            animation: fadeIn 1s ease-out;
        }
        
        .no-data i {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--accent);
        }
        
        @media (max-width: 768px) {
            .salary-container {
                padding: 1.5rem;
            }
            
            h2 {
                font-size: 1.8rem;
            }
            
            .stats-container {
                grid-template-columns: 1fr;
            }
            
            .salary-table th, 
            .salary-table td {
                padding: 0.8rem;
                font-size: 0.85rem;
            }
        }
    </style>
</head>
<body>
    <div class="salary-container">
        <h2><i class="fas fa-money-bill-wave"></i> Faculty Salary Dashboard</h2>
        
        <div class="stats-container">
            <div class="stat-card">
                <h3><i class="fas fa-users"></i> Total Faculty</h3>
                <p><?php echo $result->num_rows; ?></p>
            </div>
            <div class="stat-card">
                <h3><i class="fas fa-indian-rupee-sign"></i> Total Salary Paid</h3>
                <p>
                    <?php 
                        $total = 0;
                        if ($result->num_rows > 0) {
                            $result->data_seek(0); // Reset pointer
                            while($row = $result->fetch_assoc()) {
                                $total += $row['Amount'];
                            }
                            echo '₹' . number_format($total);
                        } else {
                            echo '₹0';
                        }
                    ?>
                </p>
            </div>
            <div class="stat-card">
                <h3><i class="fas fa-calculator"></i> Average Salary</h3>
                <p>
                    <?php 
                        if ($result->num_rows > 0) {
                            echo '₹' . number_format($total / $result->num_rows);
                        } else {
                            echo '₹0';
                        }
                    ?>
                </p>
            </div>
        </div>
        
        <div class="table-container">
            <?php if ($result->num_rows > 0): ?>
            <?php $result->data_seek(0); // Reset pointer for second loop ?>
            <table class="salary-table" id="salaryTable">
                <thead>
                    <tr>
                        <th>Faculty ID</th>
                        <th>Amount</th>
                        <th>Department</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['Faculty_ID']); ?></td>
                        <td class="amount-cell">
                            <i class="fas fa-indian-rupee-sign"></i>
                            <?php echo number_format($row['Amount']); ?>
                        </td>
                        <td class="department-cell">
                            <span class="department-badge">
                                <?php echo htmlspecialchars($row['Department']); ?>
                            </span>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="no-data">
                <i class="fas fa-database"></i>
                <p>No salary records found</p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#salaryTable').DataTable({
                responsive: true,
                dom: '<"top"f>rt<"bottom"lip><"clear">',
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search faculty...",
                },
                initComplete: function() {
                    $('.dataTables_filter input').addClass('search-input');
                }
            });
            
            // Animate table rows on load
            $('.salary-table tbody tr').each(function(i) {
                $(this).css('opacity', 0);
                $(this).delay(i * 100).animate({
                    opacity: 1
                }, 300);
            });
        });
    </script>
</body>
</html>