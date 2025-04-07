<?php
include("db_config.php");

$result = $conn->query("SELECT * FROM courses");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Display Courses</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
  <style>
    :root {
      --primary-color: #6c5ce7;
      --secondary-color: #a29bfe;
      --accent-color: #fd79a8;
      --light-color: #f8f9fa;
      --dark-color: #2d3436;
      --success-color: #00b894;
      --error-color: #d63031;
      --card-bg: #ffffff;
      --shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
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
      color: var(--dark-color);
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 0.5rem;
      background: linear-gradient(to right, var(--primary-color), var(--accent-color));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      display: inline-block;
    }
    
    .header p {
      color: #666;
      font-size: 1.1rem;
    }
    
    .table-container {
      max-width: 1200px;
      margin: 0 auto;
      background: var(--card-bg);
      border-radius: 16px;
      box-shadow: var(--shadow);
      overflow: hidden;
      animation: fadeIn 0.8s;
      transition: all 0.3s ease;
    }
    
    .table-container:hover {
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
      transform: translateY(-5px);
    }
    
    table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
    }
    
    thead {
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
      color: white;
    }
    
    th {
      padding: 18px 16px;
      text-align: left;
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
      border-left: 4px solid var(--accent-color);
    }
    
    .no-data {
      text-align: center;
      padding: 40px;
      color: #777;
    }
    
    .no-data i {
      font-size: 3rem;
      color: var(--secondary-color);
      margin-bottom: 1rem;
    }
    
    .no-data h3 {
      color: var(--dark-color);
      margin-bottom: 0.5rem;
    }
    
    .badge {
      display: inline-block;
      padding: 4px 8px;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: 500;
      background: rgba(0, 184, 148, 0.1);
      color: var(--success-color);
    }
    
    .pagination {
      display: flex;
      justify-content: center;
      margin-top: 2rem;
      gap: 8px;
    }
    
    .pagination button {
      background: white;
      border: none;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.3s;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    
    .pagination button:hover {
      background: var(--primary-color);
      color: white;
      transform: translateY(-2px);
    }
    
    .pagination button.active {
      background: var(--primary-color);
      color: white;
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
      
      .table-container {
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
    <h1>Course Catalog</h1>
    <p>Browse all available courses in our database</p>
  </div>

  <div class="table-container animate__animated animate__fadeIn">
    <table>
      <thead>
        <tr>
          <th>Course ID</th>
          <th>Course Name</th>
          <th>Department</th>
          <th>Credits</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr class="animate__animated animate__fadeIn" style="animation-delay: <?= rand(0, 300) / 1000 ?>s">
              <td><span class="badge"><?= htmlspecialchars($row['course_id']) ?></span></td>
              <td><?= htmlspecialchars($row['course_name']) ?></td>
              <td><?= htmlspecialchars($row['department']) ?></td>
              <td><?= htmlspecialchars($row['credits']) ?></td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="4" class="no-data animate__animated animate__fadeIn">
              <i class="fas fa-book-open"></i>
              <h3>No Courses Available</h3>
              <p>There are currently no courses in the database.</p>
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- Pagination would go here -->
  <div class="pagination animate__animated animate__fadeIn">
    <button><i class="fas fa-chevron-left"></i></button>
    <button class="active">1</button>
    <button>2</button>
    <button>3</button>
    <button><i class="fas fa-chevron-right"></i></button>
  </div>

  <script>
    // Add staggered animations to table rows
    document.addEventListener('DOMContentLoaded', function() {
      const rows = document.querySelectorAll('tbody tr');
      rows.forEach((row, index) => {
        // Only apply if it's not the "no data" row
        if (!row.querySelector('.no-data')) {
          row.style.animationDelay = `${index * 0.05}s`;
        }
      });
      
      // Add hover effect to pagination
      const paginationButtons = document.querySelectorAll('.pagination button');
      paginationButtons.forEach(button => {
        button.addEventListener('mouseenter', () => {
          button.style.transform = 'translateY(-3px)';
          button.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.1)';
        });
        button.addEventListener('mouseleave', () => {
          if (!button.classList.contains('active')) {
            button.style.transform = 'translateY(0)';
            button.style.boxShadow = '0 2px 5px rgba(0, 0, 0, 0.1)';
          }
        });
      });
    });
  </script>
</body>
</html>