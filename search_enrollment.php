<?php
include("db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Use prepared statement to prevent SQL injection
    $student_prn = $_POST['student_prn'];
    $stmt = $conn->prepare("SELECT * FROM enrollment WHERE Student_PRN = ?");
    $stmt->bind_param("s", $student_prn);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search Enrollment</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    :root {
      --primary: #4361ee;
      --secondary: #3a0ca3;
      --accent: #f72585;
      --light: #f8f9fa;
      --dark: #212529;
      --success: #4cc9f0;
      --error: #ef233c;
      --card-bg: #ffffff;
      --shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
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
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    .container {
      max-width: 800px;
      width: 100%;
      background: var(--card-bg);
      border-radius: 20px;
      box-shadow: var(--shadow);
      padding: 40px;
      animation: fadeInUp 0.8s;
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }

    .container:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .container::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 8px;
      background: linear-gradient(90deg, var(--primary), var(--accent));
    }

    h1 {
      color: var(--dark);
      text-align: center;
      margin-bottom: 30px;
      font-weight: 700;
      position: relative;
      padding-bottom: 15px;
    }

    h1::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 80px;
      height: 4px;
      background: var(--accent);
      border-radius: 2px;
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 20px;
      margin-bottom: 30px;
    }

    .search-group {
      display: flex;
      gap: 10px;
    }

    input {
      flex: 1;
      padding: 15px 20px;
      border: 2px solid #e0e0e0;
      border-radius: 10px;
      font-size: 16px;
      transition: all 0.3s;
      outline: none;
      background: #f8f9fa;
    }

    input:focus {
      border-color: var(--primary);
      background: white;
      box-shadow: 0 0 0 4px rgba(67, 97, 238, 0.1);
    }

    button {
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      color: white;
      border: none;
      padding: 15px 25px;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    button:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 20px rgba(67, 97, 238, 0.3);
    }

    button:active {
      transform: translateY(0);
    }

    .results-container {
      margin-top: 30px;
      animation: fadeIn 0.5s;
    }

    table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
      background: white;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    thead {
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      color: white;
    }

    th {
      padding: 15px;
      text-align: left;
      font-weight: 500;
    }

    td {
      padding: 12px 15px;
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
    }

    tr:last-child td {
      border-bottom: none;
    }

    tr:hover td {
      background: rgba(67, 97, 238, 0.05);
      transform: translateX(5px);
    }

    .no-results {
      text-align: center;
      padding: 30px;
      color: #666;
      animation: fadeIn 0.5s;
    }

    .no-results i {
      font-size: 3rem;
      color: var(--secondary);
      margin-bottom: 15px;
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

    @media (max-width: 768px) {
      .container {
        padding: 30px;
      }
      
      h1 {
        font-size: 1.8rem;
      }
      
      .search-group {
        flex-direction: column;
      }
      
      input, button {
        width: 100%;
      }
    }

    @media (max-width: 480px) {
      .container {
        padding: 25px 20px;
        border-radius: 15px;
      }
      
      h1 {
        font-size: 1.5rem;
        margin-bottom: 20px;
      }
      
      th, td {
        padding: 10px;
        font-size: 0.9rem;
      }
    }
  </style>
</head>
<body>
  <div class="container animate__animated animate__fadeInUp">
    <h1><i class="fas fa-search"></i> Search Enrollment</h1>
    
    <form method="POST">
      <div class="search-group animate__animated animate__fadeIn">
        <input type="text" name="student_prn" placeholder="Enter Student PRN" required>
        <button type="submit">
          <i class="fas fa-search"></i> Search
        </button>
      </div>
    </form>
    
    <?php if (isset($result)): ?>
      <div class="results-container">
        <?php if ($result->num_rows > 0): ?>
          <table>
            <thead>
              <tr>
                <th>Student PRN</th>
                <th>Student Name</th>
                <th>Course ID</th>
                <th>Course Name</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($row = $result->fetch_assoc()): ?>
                <tr class="animate__animated animate__fadeIn">
                  <td><?php echo htmlspecialchars($row['Student_PRN']); ?></td>
                  <td><?php echo htmlspecialchars($row['Student_Name']); ?></td>
                  <td><?php echo htmlspecialchars($row['Course_ID']); ?></td>
                  <td><?php echo htmlspecialchars($row['Course_Name']); ?></td>
                </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        <?php else: ?>
          <div class="no-results animate__animated animate__fadeIn">
            <i class="fas fa-user-slash"></i>
            <h3>No Enrollments Found</h3>
            <p>No records found for the provided Student PRN.</p>
          </div>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>

  <script>
    // Add animation to table rows
    document.addEventListener('DOMContentLoaded', function() {
      const rows = document.querySelectorAll('tbody tr');
      rows.forEach((row, index) => {
        row.style.animationDelay = `${index * 0.1}s`;
      });
    });
  </script>
</body>
</html>