<?php
include("db_config.php");

$result = $conn->query("SELECT * FROM faculty");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Faculty Directory</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary: #4361ee;
      --primary-light: #4895ef;
      --secondary: #3f37c9;
      --dark: #1e1e24;
      --light: #f8f9fa;
      --gray: #6c757d;
      --success: #4cc9f0;
      --warning: #f72585;
      --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      --shadow-lg: 0 10px 15px rgba(0, 0, 0, 0.1);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
      color: var(--dark);
      min-height: 100vh;
      padding: 20px;
    }

    .display-container {
      max-width: 1200px;
      margin: 40px auto;
      background: white;
      padding: 40px;
      border-radius: 16px;
      box-shadow: var(--shadow-lg);
      transform: translateY(-20px);
      opacity: 0;
      animation: fadeInUp 0.6s ease-out forwards;
    }

    @keyframes fadeInUp {
      from {
        transform: translateY(20px);
        opacity: 0;
      }
      to {
        transform: translateY(0);
        opacity: 1;
      }
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
      flex-wrap: wrap;
      gap: 20px;
    }

    h1 {
      color: var(--dark);
      font-size: 2.2rem;
      font-weight: 600;
      position: relative;
      display: inline-block;
    }

    h1::after {
      content: '';
      position: absolute;
      bottom: -8px;
      left: 0;
      width: 60px;
      height: 4px;
      background: var(--primary);
      border-radius: 2px;
    }

    .search-container {
      display: flex;
      gap: 10px;
    }

    .search-box {
      padding: 10px 15px;
      border: 2px solid #e9ecef;
      border-radius: 8px;
      font-size: 1rem;
      transition: all 0.3s;
      width: 250px;
    }

    .search-box:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
    }

    .btn {
      padding: 10px 20px;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    .btn-primary {
      background: var(--primary);
      color: white;
    }

    .btn-primary:hover {
      background: var(--secondary);
      transform: translateY(-2px);
    }

    table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
      margin-top: 20px;
      overflow: hidden;
    }

    thead {
      position: sticky;
      top: 0;
    }

    th {
      background: var(--primary);
      color: white;
      padding: 16px;
      text-align: left;
      font-weight: 500;
      position: relative;
    }

    th:not(:last-child)::after {
      content: '';
      position: absolute;
      right: 0;
      top: 50%;
      transform: translateY(-50%);
      height: 60%;
      width: 1px;
      background: rgba(255, 255, 255, 0.3);
    }

    td {
      padding: 16px;
      border-bottom: 1px solid #e9ecef;
      transition: all 0.3s;
    }

    tr:last-child td {
      border-bottom: none;
    }

    tr:hover td {
      background: rgba(67, 97, 238, 0.05);
      transform: scale(1.01);
    }

    .status {
      display: inline-block;
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 0.85rem;
      font-weight: 500;
    }

    .status-active {
      background: rgba(76, 201, 240, 0.1);
      color: var(--success);
    }

    .no-data {
      text-align: center;
      padding: 40px;
      color: var(--gray);
      font-size: 1.1rem;
    }

    .no-data i {
      font-size: 2rem;
      margin-bottom: 15px;
      color: #dee2e6;
    }

    .pagination {
      display: flex;
      justify-content: center;
      margin-top: 30px;
      gap: 8px;
    }

    .page-item {
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 8px;
      cursor: pointer;
      transition: all 0.3s;
    }

    .page-item:hover {
      background: #e9ecef;
    }

    .page-item.active {
      background: var(--primary);
      color: white;
    }

    .action-btn {
      background: none;
      border: none;
      color: var(--gray);
      cursor: pointer;
      transition: all 0.3s;
      padding: 5px;
      border-radius: 4px;
    }

    .action-btn:hover {
      color: var(--primary);
      background: rgba(67, 97, 238, 0.1);
    }

    @media (max-width: 768px) {
      .display-container {
        padding: 20px;
      }
      
      table {
        display: block;
        overflow-x: auto;
      }
      
      .search-container {
        width: 100%;
      }
      
      .search-box {
        width: 100%;
      }
    }

    /* Loading animation */
    .loading {
      display: flex;
      justify-content: center;
      padding: 30px;
    }

    .loading-circle {
      width: 12px;
      height: 12px;
      margin: 0 5px;
      background-color: var(--primary);
      border-radius: 50%;
      animation: loading 1.2s infinite ease-in-out;
    }

    .loading-circle:nth-child(1) {
      animation-delay: 0s;
    }

    .loading-circle:nth-child(2) {
      animation-delay: 0.2s;
    }

    .loading-circle:nth-child(3) {
      animation-delay: 0.4s;
    }

    @keyframes loading {
      0%, 100% {
        transform: translateY(0);
      }
      50% {
        transform: translateY(-15px);
      }
    }
  </style>
</head>
<body>
  <div class="display-container">
    <div class="header">
      <h1>Faculty Directory</h1>
      <div class="search-container">
        <input type="text" class="search-box" placeholder="Search faculty..." id="searchInput">
        <button class="btn btn-primary">
          <i class="fas fa-search"></i> Search
        </button>
      </div>
    </div>

    <?php if ($result->num_rows > 0): ?>
      <div class="table-responsive">
        <table id="facultyTable">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Contact</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($row['faculty_id']) ?></td>
                <td>
                  <div class="d-flex align-items-center">
                    <div class="ms-3">
                      <p class="fw-bold mb-0"><?= htmlspecialchars($row['name']) ?></p>
                      <p class="text-muted mb-0 small">Department</p>
                    </div>
                  </div>
                </td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['contact']) ?></td>
                <td>
                  <button class="action-btn" title="View">
                    <i class="fas fa-eye"></i>
                  </button>
                  <button class="action-btn" title="Edit">
                    <i class="fas fa-edit"></i>
                  </button>
                  <button class="action-btn" title="Delete">
                    <i class="fas fa-trash"></i>
                  </button>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
      
      <div class="pagination">
        <div class="page-item"><i class="fas fa-chevron-left"></i></div>
        <div class="page-item active">1</div>
        <div class="page-item">2</div>
        <div class="page-item">3</div>
        <div class="page-item"><i class="fas fa-chevron-right"></i></div>
      </div>
    <?php else: ?>
      <div class="no-data">
        <i class="fas fa-user-graduate fa-2x"></i>
        <p>No faculty records found</p>
        <button class="btn btn-primary mt-3">
          <i class="fas fa-plus"></i> Add New Faculty
        </button>
      </div>
    <?php endif; ?>
  </div>

  <script>
    // Simple search functionality
    document.getElementById('searchInput').addEventListener('input', function() {
      const searchValue = this.value.toLowerCase();
      const rows = document.querySelectorAll('#facultyTable tbody tr');
      
      rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(searchValue) ? '' : 'none';
      });
    });

    // Animation for table rows
    document.addEventListener('DOMContentLoaded', () => {
      const rows = document.querySelectorAll('#facultyTable tbody tr');
      rows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateX(-20px)';
        row.style.animation = `fadeInRight 0.5s ease-out ${index * 0.1}s forwards`;
      });
      
      // Add animation to styles
      const style = document.createElement('style');
      style.textContent = `
        @keyframes fadeInRight {
          from {
            opacity: 0;
            transform: translateX(-20px);
          }
          to {
            opacity: 1;
            transform: translateX(0);
          }
        }
      `;
      document.head.appendChild(style);
    });
  </script>
</body>
</html>