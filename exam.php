<?php
include("db_config.php");

$sql = "SELECT * FROM exam_details";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Exam Schedule</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    :root {
      --primary: #6c5ce7;
      --secondary: #a29bfe;
      --accent: #fd79a8;
      --light: #f8f9fa;
      --dark: #2d3436;
      --success: #00b894;
      --error: #d63031;
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
      background: linear-gradient(135deg, #f5f7fa 0%, #dfe6f0 100%);
      min-height: 100vh;
      padding: 2rem;
    }

    .header {
      text-align: center;
      margin-bottom: 2rem;
      animation: fadeInDown 0.8s;
    }

    .header h1 {
      color: var(--dark);
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
      background: linear-gradient(to right, var(--primary), var(--accent));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .header p {
      color: #666;
      font-size: 1.1rem;
    }

    .container {
      max-width: 1000px;
      margin: 0 auto;
      background: var(--card-bg);
      border-radius: 16px;
      box-shadow: var(--shadow);
      overflow: hidden;
      animation: fadeIn 0.8s;
      transition: all 0.3s ease;
    }

    .container:hover {
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
      transform: translateY(-5px);
    }

    table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
    }

    thead {
      background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
      color: white;
    }

    th {
      padding: 18px 16px;
      text-align: center;
      font-weight: 500;
      position: sticky;
      top: 0;
    }

    th:first-child {
      border-top-left-radius: 16px;
    }

    th:last-child {
      border-top-right-radius: 16px;
    }

    td {
      padding: 16px;
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
      text-align: center;
      transition: all 0.3s ease;
    }

    tr:last-child td {
      border-bottom: none;
    }

    tr:hover td {
      background: rgba(108, 92, 231, 0.05);
      transform: scale(1.01);
    }

    tr:hover td:first-child {
      border-left: 4px solid var(--accent);
    }

    .exam-date {
      font-weight: 600;
      color: var(--primary);
    }

    .exam-time {
      display: inline-block;
      padding: 4px 10px;
      border-radius: 20px;
      background: rgba(0, 184, 148, 0.1);
      color: var(--success);
      font-weight: 500;
    }

    .no-data {
      text-align: center;
      padding: 40px;
      color: #777;
      animation: fadeIn 0.8s;
    }

    .no-data i {
      font-size: 3rem;
      color: var(--secondary);
      margin-bottom: 1rem;
    }

    .no-data h3 {
      color: var(--dark);
      margin-bottom: 0.5rem;
    }

    .countdown-badge {
      display: inline-block;
      padding: 4px 8px;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: 500;
      background: rgba(253, 121, 168, 0.1);
      color: var(--accent);
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
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
    @media (max-width: 768px) {
      body {
        padding: 1rem;
      }
      
      .header h1 {
        font-size: 2rem;
      }
      
      th, td {
        padding: 12px 8px;
        font-size: 0.9rem;
      }
      
      .container {
        border-radius: 12px;
      }
    }

    @media (max-width: 576px) {
      .header h1 {
        font-size: 1.8rem;
      }
      
      .header p {
        font-size: 1rem;
      }
      
      table {
        display: block;
        overflow-x: auto;
      }
    }
  </style>
</head>
<body>
  <div class="header animate__animated animate__fadeInDown">
    <h1><i class="fas fa-calendar-alt"></i> Exam Schedule</h1>
    <p>View all upcoming examinations</p>
  </div>

  <div class="container animate__animated animate__fadeIn">
    <table>
      <thead>
        <tr>
          <th>Course</th>
          <th>Date</th>
          <th>Time</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr class="animate__animated animate__fadeIn" style="animation-delay: <?= rand(0, 300) / 1000 ?>s">
              <td><?= htmlspecialchars($row['course_name']) ?></td>
              <td class="exam-date"><?= htmlspecialchars($row['exam_date']) ?></td>
              <td><span class="exam-time"><?= htmlspecialchars($row['exam_time']) ?></span></td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="3" class="no-data animate__animated animate__fadeIn">
              <i class="fas fa-calendar-times"></i>
              <h3>No Exams Scheduled</h3>
              <p>There are currently no exams in the database.</p>
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <script>
    // Add animation to table rows
    document.addEventListener('DOMContentLoaded', function() {
      const rows = document.querySelectorAll('tbody tr');
      rows.forEach((row, index) => {
        // Only apply if it's not the "no data" row
        if (!row.querySelector('.no-data')) {
          row.style.animationDelay = `${index * 0.05}s`;
        }
      });
      
      // Add exam date countdown functionality (example)
      const examDates = document.querySelectorAll('.exam-date');
      examDates.forEach(dateCell => {
        const examDate = new Date(dateCell.textContent);
        const today = new Date();
        const diffTime = examDate - today;
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        
        if (diffDays > 0) {
          const countdownBadge = document.createElement('span');
          countdownBadge.className = 'countdown-badge';
          countdownBadge.textContent = `${diffDays} days left`;
          dateCell.appendChild(document.createElement('br'));
          dateCell.appendChild(countdownBadge);
        }
      });
    });
  </script>
</body>
</html>