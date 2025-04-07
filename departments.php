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
    <title>Department Directory</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #5e35b1;
            --secondary: #3949ab;
            --accent: #7c4dff;
            --light: #f5f3ff;
            --dark: #1a237e;
            --card-bg: #ffffff;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #ede7f6 0%, #d1c4e9 100%);
            min-height: 100vh;
            padding: 2rem;
        }

        .department-container {
            max-width: 800px;
            margin: 0 auto;
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: var(--shadow);
            overflow: hidden;
            animation: fadeInUp 0.8s;
            transition: all 0.3s ease;
        }

        .department-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        h2 {
            padding: 1.5rem;
            text-align: center;
            color: var(--dark);
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            position: relative;
        }

        h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: var(--accent);
            border-radius: 2px;
        }

        .department-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .department-table th {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 1rem;
            text-align: left;
            font-weight: 500;
            position: sticky;
            top: 0;
        }

        .department-table td {
            padding: 1rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .department-table tr:last-child td {
            border-bottom: none;
        }

        .department-table tr:hover td {
            background: rgba(94, 53, 177, 0.05);
            transform: translateX(5px);
        }

        .department-id {
            font-weight: 600;
            color: var(--primary);
        }

        .department-name {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .department-icon {
            color: var(--accent);
            font-size: 1.2rem;
        }

        .no-departments {
            text-align: center;
            padding: 3rem;
            color: #666;
            animation: fadeIn 0.8s;
        }

        .no-departments i {
            font-size: 3rem;
            color: var(--secondary);
            margin-bottom: 1rem;
        }

        .no-departments h3 {
            color: var(--dark);
            margin-bottom: 0.5rem;
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

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
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
        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }
            
            .department-container {
                border-radius: 12px;
            }
            
            h2 {
                font-size: 1.8rem;
                padding: 1.2rem;
            }
            
            .department-table th, 
            .department-table td {
                padding: 0.8rem;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .department-container {
                border-radius: 10px;
            }
            
            h2 {
                font-size: 1.5rem;
            }
            
            .department-name {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }
            
            .department-icon {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="department-container animate__animated animate__fadeInUp">
        <h2><i class="fas fa-building"></i> Department Directory</h2>
        
        <table class="department-table">
            <thead>
                <tr>
                    <th>Department ID</th>
                    <th>Department Name</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr class="animate__animated animate__fadeIn">
                            <td class="department-id"><?= htmlspecialchars($row['Dept_ID']) ?></td>
                            <td class="department-name">
                                <i class="fas fa-university department-icon"></i>
                                <?= htmlspecialchars($row['Dept_Name']) ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2" class="no-departments animate__animated animate__fadeIn">
                            <i class="fas fa-exclamation-circle"></i>
                            <h3>No Departments Found</h3>
                            <p>There are currently no departments in the database.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script>
        // Add animation to table rows
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('.department-table tbody tr');
            rows.forEach((row, index) => {
                // Only apply if it's not the "no departments" row
                if (!row.querySelector('.no-departments')) {
                    row.style.animationDelay = `${index * 0.1}s`;
                }
            });
        });
    </script>
</body>
</html>