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
    <title>Student Feedback Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #4f46e5;
            --secondary: #6366f1;
            --accent: #ec4899;
            --light: #f8fafc;
            --dark: #1e293b;
            --success: #10b981;
            --warning: #f59e0b;
            --error: #ef4444;
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
            background: linear-gradient(to right, var(--primary), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .dashboard-header p {
            color: #64748b;
            font-size: 1.1rem;
        }

        .feedback-container {
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: all 0.3s ease;
            animation: fadeInUp 0.8s;
        }

        .feedback-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }

        .feedback-header {
            padding: 1.5rem 2rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .feedback-header h2 {
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .feedback-count {
            background: rgba(255, 255, 255, 0.2);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .feedback-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .feedback-table th {
            padding: 1rem 1.5rem;
            text-align: left;
            background: #f8fafc;
            color: var(--dark);
            font-weight: 600;
            border-bottom: 2px solid #e2e8f0;
            position: sticky;
            top: 0;
        }

        .feedback-table td {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #f1f5f9;
            transition: all 0.3s ease;
        }

        .feedback-table tr:last-child td {
            border-bottom: none;
        }

        .feedback-table tr:hover td {
            background: rgba(79, 70, 229, 0.03);
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
            color: var(--accent);
        }

        .feedback-message {
            position: relative;
            padding-left: 1.5rem;
        }

        .feedback-message::before {
            content: '"';
            position: absolute;
            left: 0;
            top: 0;
            font-size: 2rem;
            color: #cbd5e1;
            line-height: 1;
        }

        .no-feedback {
            text-align: center;
            padding: 3rem;
            color: #64748b;
            animation: fadeIn 0.8s;
        }

        .no-feedback i {
            font-size: 3rem;
            color: var(--secondary);
            margin-bottom: 1rem;
        }

        .no-feedback h3 {
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .sentiment-positive {
            color: var(--success);
        }

        .sentiment-neutral {
            color: var(--warning);
        }

        .sentiment-negative {
            color: var(--error);
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
            .feedback-container {
                border-radius: 12px;
            }
            
            .feedback-header {
                padding: 1.25rem 1.5rem;
            }
            
            .feedback-table th, 
            .feedback-table td {
                padding: 1rem;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 1.5rem;
            }
            
            .dashboard-header h1 {
                font-size: 2rem;
            }
            
            .feedback-table {
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
            
            .feedback-header h2 {
                font-size: 1.2rem;
            }
            
            .feedback-count {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="dashboard-header animate__animated animate__fadeInDown">
            <h1><i class="fas fa-comment-dots"></i> Student Feedback Dashboard</h1>
            <p>View and analyze student feedback for continuous improvement</p>
        </div>

        <div class="feedback-container animate__animated animate__fadeInUp">
            <div class="feedback-header">
                <h2><i class="fas fa-clipboard-list"></i> Feedback Records</h2>
                <span class="feedback-count">
                    <?php echo $result ? $result->num_rows : '0'; ?> entries
                </span>
            </div>

            <table class="feedback-table">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Feedback</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr class="animate__animated animate__fadeIn">
                                <td class="student-prn">
                                    <?= htmlspecialchars($row['Student_PRN']) ?>
                                </td>
                                <td class="course-name">
                                    <i class="fas fa-book course-icon"></i>
                                    <?= htmlspecialchars($row['Course_Name']) ?>
                                </td>
                                <td class="feedback-message">
                                    <?= nl2br(htmlspecialchars($row['Message'])) ?>
                                    <div class="sentiment-tag" style="margin-top: 8px;">
                                        <!-- This would be populated with sentiment analysis in a real implementation -->
                                        <span class="sentiment-positive">
                                            <i class="fas fa-smile"></i> Positive
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="no-feedback animate__animated animate__fadeIn">
                                <i class="fas fa-comment-slash"></i>
                                <h3>No Feedback Available</h3>
                                <p>There are currently no feedback submissions in the database.</p>
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
            const rows = document.querySelectorAll('.feedback-table tbody tr');
            rows.forEach((row, index) => {
                // Only apply if it's not the "no feedback" row
                if (!row.querySelector('.no-feedback')) {
                    row.style.animationDelay = `${index * 0.05}s`;
                }
            });

            // Example sentiment analysis (would be server-side in real implementation)
            const messages = document.querySelectorAll('.feedback-message');
            messages.forEach(message => {
                const text = message.textContent.toLowerCase();
                const sentimentTag = message.querySelector('.sentiment-tag span');
                
                if (text.includes('excellent') || text.includes('great') || text.includes('awesome')) {
                    sentimentTag.className = 'sentiment-positive';
                    sentimentTag.innerHTML = '<i class="fas fa-smile"></i> Positive';
                } else if (text.includes('poor') || text.includes('bad') || text.includes('terrible')) {
                    sentimentTag.className = 'sentiment-negative';
                    sentimentTag.innerHTML = '<i class="fas fa-frown"></i> Negative';
                } else {
                    sentimentTag.className = 'sentiment-neutral';
                    sentimentTag.innerHTML = '<i class="fas fa-meh"></i> Neutral';
                }
            });
        });
    </script>
</body>
</html>