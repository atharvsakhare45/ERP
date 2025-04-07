<?php
include("db_config.php");

$search_result = null;
$no_results = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search = trim($_POST['course_id']);

    if (!empty($search)) {
        $search = "%$search%"; // For partial match
        $stmt = $conn->prepare("SELECT * FROM courses WHERE course_id LIKE ? OR course_name LIKE ?");
        $stmt->bind_param("ss", $search, $search);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $search_result = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $no_results = true;
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Search Course Results</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
  <style>
    :root {
      --primary-color: #4361ee;
      --secondary-color: #3f37c9;
      --accent-color: #4cc9f0;
      --light-color: #f8f9fa;
      --dark-color: #212529;
      --success-color: #4bb543;
      --error-color: #ff3333;
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    body {
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      min-height: 100vh;
      padding: 2rem;
    }
    
    .form-container {
      max-width: 600px;
      margin: 2rem auto;
      padding: 2rem;
      background: white;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
      animation: fadeInDown 0.8s;
    }
    
    .form-container:hover {
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
      transform: translateY(-5px);
    }
    
    h2 {
      color: var(--primary-color);
      text-align: center;
      margin-bottom: 1.5rem;
      font-weight: 600;
      position: relative;
      padding-bottom: 10px;
    }
    
    h2::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
      width: 80px;
      height: 3px;
      background: var(--accent-color);
      border-radius: 3px;
    }
    
    form {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }
    
    input {
      padding: 12px 15px;
      border: 2px solid #e0e0e0;
      border-radius: 8px;
      font-size: 16px;
      transition: all 0.3s;
      outline: none;
    }
    
    input:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
    }
    
    button {
      background: var(--primary-color);
      color: white;
      border: none;
      padding: 12px;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }
    
    button:hover {
      background: var(--secondary-color);
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(67, 97, 238, 0.4);
    }
    
    button:active {
      transform: translateY(0);
    }
    
    .result-container {
      max-width: 1000px;
      margin: 2rem auto;
      animation: fadeIn 0.8s;
    }
    
    .result-table {
      width: 100%;
      border-collapse: separate;
      border-spacing: 0;
      background: white;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    
    .result-table th {
      background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
      color: white;
      padding: 15px;
      text-align: left;
      position: sticky;
      top: 0;
    }
    
    .result-table td {
      padding: 12px 15px;
      border-bottom: 1px solid #f0f0f0;
      transition: all 0.2s;
    }
    
    .result-table tr:last-child td {
      border-bottom: none;
    }
    
    .result-table tr:hover td {
      background: rgba(67, 97, 238, 0.05);
      transform: translateX(5px);
    }
    
    .no-result {
      text-align: center;
      padding: 2rem;
      background: white;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      max-width: 600px;
      margin: 2rem auto;
      animation: fadeIn 0.8s;
    }
    
    .no-result i {
      font-size: 3rem;
      color: var(--error-color);
      margin-bottom: 1rem;
    }
    
    .no-result h3 {
      color: var(--dark-color);
      margin-bottom: 0.5rem;
    }
    
    .no-result p {
      color: #666;
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
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
      body {
        padding: 1rem;
      }
      
      .form-container {
        padding: 1.5rem;
      }
      
      .result-table {
        font-size: 14px;
      }
      
      .result-table th, 
      .result-table td {
        padding: 10px 8px;
      }
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Search Course</h2>
    <form method="POST" action="search_course.php">
      <input type="text" name="course_id" placeholder="Enter Course ID or Name" autocomplete="off">
      <button type="submit">
        <i class="fas fa-search"></i> Search
      </button>
    </form>
  </div>

  <?php if ($search_result): ?>
    <div class="result-container animate__animated animate__fadeIn">
      <table class="result-table">
        <thead>
          <tr>
            <th>Course ID</th>
            <th>Course Name</th>
            <th>Department</th>
            <th>Credits</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($search_result as $course): ?>
            <tr class="animate__animated animate__fadeIn">
              <td><?= htmlspecialchars($course['course_id']) ?></td>
              <td><?= htmlspecialchars($course['course_name']) ?></td>
              <td><?= htmlspecialchars($course['department']) ?></td>
              <td><?= htmlspecialchars($course['credits']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php elseif ($no_results): ?>
    <div class="no-result animate__animated animate__fadeIn">
      <i class="fas fa-exclamation-circle"></i>
      <h3>No Results Found</h3>
      <p>We couldn't find any courses matching your search.</p>
    </div>
  <?php endif; ?>

  <script>
    // Add animation to table rows
    document.addEventListener('DOMContentLoaded', function() {
      const rows = document.querySelectorAll('.result-table tbody tr');
      rows.forEach((row, index) => {
        row.style.animationDelay = `${index * 0.1}s`;
      });
    });
  </script>
</body>
</html>