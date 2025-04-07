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
    <title>Attendance Tracker</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #3b82f6;
            --secondary: #2563eb;
            --present: #10b981;
            --absent: #ef4444;
            --late: #f59e0b;
            --light: #f8fafc;
            --dark: #1e293b;
            --card-bg: #ffffff;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            min-height: 100vh;
            padding: 2rem;
        }

        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            animation: fadeIn 0.6s;
        }

        .dashboard-header {
            text-align: center;
            margin-bottom: 2rem;
            animation: fadeInDown 0.8s;
        }

        .dashboard-header h1 {
            color: var(--dark);
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .dashboard-header p {
            color: #64748b;
            font-size: 1.1rem;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
            animation: fadeInUp 0.8s;
        }

        .stat-card {
            background: var(--card-bg);
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .present-stat .stat-icon {
            background: rgba(16, 185, 129, 0.1);
            color: var(--present);
        }

        .absent-stat .stat-icon {
            background: rgba(239, 68, 68, 0.1);
            color: var(--absent);
        }

        .total-stat .stat-icon {
            background: rgba(59, 130, 246, 0.1);
            color: var(--primary);
        }

        .stat-info h3 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .stat-info p {
            color: #64748b;
            font-size: 0.9rem;
        }

        .attendance-container {
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: all 0.3s ease;
            animation: fadeInUp 0.8s;
        }

        .attendance-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }

        .attendance-header {
            padding: 1.5rem 2rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .attendance-header h2 {
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .attendance-count {
            background: rgba(255, 255, 255, 0.2);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .attendance-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .attendance-table th {
            padding: 1rem 1.5rem;
            text-align: left;
            background: #f8fafc;
            color: var(--dark);
            font-weight: 600;
            border-bottom: 2px solid #e2e8f0;
            position: sticky;
            top: 0;
        }

        .attendance-table td {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            transition: all 0.3s ease;
        }

        .attendance-table tr:last-child td {
            border-bottom: none;
        }

        .attendance-table tr:hover td {
            background: rgba(59, 130, 246, 0.03);
            transform: translateX(5px);
        }

        .student-prn {
            font-weight: 600;
            color: var(--primary);
        }

        .course-name {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .course-icon {
            color: var(--primary);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.85rem;
        }

        .present {
            background: rgba(16, 185, 129, 0.1);
            color: var(--present);
        }

        .absent {
            background: rgba(239, 68, 68, 0.1);
            color: var(--absent);
        }

        .late {
            background: rgba(245, 158, 11, 0.1);
            color: var(--late);
        }

        .no-attendance {
            text-align: center;
            padding: 3rem;
            color: #64748b;
            animation: fadeIn 0.8s;
        }

        .no-attendance i {
            font-size: 3rem;
            color: var(--secondary);
            margin-bottom: 1rem;
        }

        .no-attendance h3 {
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes rowEntry {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Responsive adjustments */
        @media (max-width: 1024px) {
            .stats-container {
                grid-template-columns: 1fr;
            }
            
            .attendance-container {
                border-radius: 12px;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 1.5rem;
            }
            
            .dashboard-header h1 {
                font-size: 2rem;
            }
            
            .attendance-table {
                display: block;
                overflow-x: auto;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 1rem;
            }
            
            .dashboard-header h1 {
                font-size: 1.8rem;
            }
            
            .attendance-header h2 {
                font-size: 1.2rem;
            }
            
            .attendance-count {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header animate__animated animate__fadeInDown">
            <h1><i class="fas fa-calendar-check"></i> Attendance Tracker</h1>
            <p>Monitor and analyze student attendance records</p>
        </div>

        <?php
        // Calculate attendance stats
        $total = 0;
        $present = 0;
        $absent = 0;
        
        if ($result && $result->num_rows > 0) {
            $total = $result->num_rows;
            $result->data_seek(0); // Reset pointer
            while ($row = $result->fetch_assoc()) {
                if (strtoupper($row['Status']) == 'PRESENT') $present++;
                if (strtoupper($row['Status']) == 'ABSENT') $absent++;
            }
            $result->data_seek(0); // Reset pointer again for table display
        }
        ?>

        <div class="stats-container animate__animated animate__fadeInUp">
            <div class="stat-card total-stat">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3><?= $total ?></h3>
                    <p>Total Records</p>
                </div>
            </div>
            
            <div class="stat-card present-stat">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3><?= $present ?></h3>
                    <p>Present Students</p>
                </div>
            </div>
            
            <div class="stat-card absent-stat">
                <div class="stat-icon">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-info">
                    <h3><?= $absent ?></h3>
                    <p>Absent Students</p>
                </div>
            </div>
        </div>

        <div class="attendance-container animate__animated animate__fadeInUp">
            <div class="attendance-header">
                <h2><i class="fas fa-list-alt"></i> Attendance Details</h2>
                <span class="attendance-count">
                    <?= $total ?> records
                </span>
            </div>

            <table class="attendance-table">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr class="animate__animated animate__fadeIn">
                                <td class="student-prn">
                                    <i class="fas fa-user-graduate"></i>
                                    <?= htmlspecialchars($row['Student_PRN']) ?>
                                </td>
                                <td class="course-name">
                                    <i class="fas fa-book course-icon"></i>
                                    <?= htmlspecialchars($row['Course_Name']) ?>
                                </td>
                                <td>
                                    <span class="status-badge <?= strtolower($row['Status']) ?>">
                                        <?php if (strtoupper($row['Status']) == 'PRESENT'): ?>
                                            <i class="fas fa-check"></i>
                                        <?php elseif (strtoupper($row['Status']) == 'ABSENT'): ?>
                                            <i class="fas fa-times"></i>
                                        <?php else: ?>
                                            <i class="fas fa-clock"></i>
                                        <?php endif; ?>
                                        <?= htmlspecialchars($row['Status']) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="no-attendance animate__animated animate__fadeIn">
                                <i class="fas fa-calendar-times"></i>
                                <h3>No Attendance Data</h3>
                                <p>There are currently no attendance records in the database.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Add animation to table rows
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('.attendance-table tbody tr');
            rows.forEach((row, index) => {
                // Only apply if it's not the "no attendance" row
                if (!row.querySelector('.no-attendance')) {
                    row.style.animationDelay = `${index * 0.05}s`;
                }
            });
        });
    </script>
</body>
</html>