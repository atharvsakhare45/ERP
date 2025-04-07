<?php
session_start();
require_once 'db_config.php';

$search_results = [];
$search_query = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
    $search_query = trim($_GET['search']);
    
    if (!empty($search_query)) {
        try {
            // Using prepared statements to prevent SQL injection
            $stmt = $conn->prepare("SELECT * FROM faculty WHERE name LIKE ? OR faculty_id LIKE ? OR email LIKE ? OR contact LIKE ?");
            $search_param = "%$search_query%";
            $stmt->bind_param("ssss", $search_param, $search_param, $search_param, $search_param);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $search_results = $result->fetch_all(MYSQLI_ASSOC);
            } else {
                $error = "No faculty members found matching your search.";
            }
        } catch (Exception $e) {
            $error = "Database error: " . $e->getMessage();
        }
    } else {
        $error = "Please enter a search term";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Search Faculty</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary: #6366f1;
      --primary-dark: #4f46e5;
      --secondary: #8b5cf6;
      --accent: #ec4899;
      --light: #f8fafc;
      --dark: #0f172a;
      --gray: #64748b;
      --success: #10b981;
      --danger: #ef4444;
      --warning: #f59e0b;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: linear-gradient(135deg, #f8fafc, #e2e8f0);
      min-height: 100vh;
      color: var(--dark);
    }

    .search-container {
      max-width: 1000px;
      margin: 40px auto;
      padding: 40px;
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
      border: 1px solid rgba(255, 255, 255, 0.3);
      transform: translateY(20px);
      opacity: 0;
      animation: fadeInUp 0.6s ease-out forwards;
    }

    h1 {
      text-align: center;
      color: var(--primary-dark);
      margin-bottom: 30px;
      font-size: 32px;
      font-weight: 700;
      position: relative;
    }

    h1::after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      width: 80px;
      height: 4px;
      background: linear-gradient(90deg, var(--primary), var(--secondary));
      border-radius: 2px;
    }

    form {
      display: flex;
      gap: 15px;
      margin-bottom: 30px;
      position: relative;
    }

    .search-input {
      flex: 1;
      padding: 16px 20px;
      border: 1px solid rgba(0, 0, 0, 0.1);
      border-radius: 12px;
      font-size: 16px;
      background: rgba(255, 255, 255, 0.8);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
    }

    .search-input:focus {
      border-color: var(--primary);
      box-shadow: 0 4px 20px rgba(99, 102, 241, 0.2);
      outline: none;
    }

    .search-btn {
      padding: 16px 30px;
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      color: white;
      border: none;
      border-radius: 12px;
      font-size: 16px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .search-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4);
    }

    .search-btn:active {
      transform: translateY(0);
    }

    .error {
      color: var(--danger);
      text-align: center;
      margin-bottom: 20px;
      padding: 15px;
      background: rgba(239, 68, 68, 0.1);
      border-left: 4px solid var(--danger);
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      animation: shake 0.5s ease-in-out;
    }

    .results-table-container {
      margin-top: 30px;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
      animation: fadeIn 0.6s ease-out;
    }

    .results-table {
      width: 100%;
      border-collapse: collapse;
      background: white;
    }

    .results-table th {
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      color: white;
      padding: 16px;
      text-align: left;
      font-weight: 500;
    }

    .results-table td {
      padding: 14px 16px;
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .results-table tr:last-child td {
      border-bottom: none;
    }

    .results-table tr {
      transition: all 0.3s ease;
    }

    .results-table tr:hover {
      background: rgba(99, 102, 241, 0.05);
      transform: translateX(5px);
    }

    .no-results {
      text-align: center;
      padding: 30px;
      color: var(--gray);
      font-size: 18px;
      animation: fadeIn 0.6s ease-out;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 15px;
    }

    .no-results i {
      font-size: 48px;
      color: var(--gray);
      opacity: 0.5;
    }

    .faculty-id {
      font-weight: 600;
      color: var(--primary-dark);
    }

    .action-btn {
      padding: 8px 12px;
      border-radius: 6px;
      border: none;
      cursor: pointer;
      font-size: 14px;
      transition: all 0.3s ease;
      display: inline-flex;
      align-items: center;
      gap: 5px;
    }

    .view-btn {
      background: rgba(16, 185, 129, 0.1);
      color: var(--success);
    }

    .view-btn:hover {
      background: var(--success);
      color: white;
    }

    .edit-btn {
      background: rgba(59, 130, 246, 0.1);
      color: #3b82f6;
    }

    .edit-btn:hover {
      background: #3b82f6;
      color: white;
    }

    /* Animations */
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

    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      20%, 60% { transform: translateX(-5px); }
      40%, 80% { transform: translateX(5px); }
    }

    /* Responsive styles */
    @media (max-width: 768px) {
      .search-container {
        padding: 30px;
        margin: 20px;
      }
      
      h1 {
        font-size: 28px;
      }
      
      form {
        flex-direction: column;
      }
      
      .search-input, .search-btn {
        width: 100%;
      }
      
      .results-table {
        display: block;
        overflow-x: auto;
      }
    }

    @media (max-width: 480px) {
      .search-container {
        padding: 25px 20px;
      }
      
      h1 {
        font-size: 24px;
      }
      
      .results-table th, .results-table td {
        padding: 12px;
        font-size: 14px;
      }
    }
  </style>
</head>
<body>
  <div class="search-container">
    <h1><i class="fas fa-search"></i> Search Faculty</h1>
    
    <form method="GET" action="search_faculty.php">
      <input type="text" name="search" class="search-input" placeholder="Search by name, ID, email or contact..." 
             value="<?php echo htmlspecialchars($search_query); ?>" required>
      <button type="submit" class="search-btn">
        <i class="fas fa-search"></i> Search
      </button>
    </form>
    
    <?php if (!empty($error)): ?>
      <div class="error">
        <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
      </div>
    <?php endif; ?>
    
    <?php if (!empty($search_results)): ?>
      <div class="results-table-container">
        <table class="results-table">
          <thead>
            <tr>
              <th>Faculty ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Contact</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($search_results as $faculty): ?>
              <tr>
                <td class="faculty-id"><?php echo htmlspecialchars($faculty['faculty_id']); ?></td>
                <td><?php echo htmlspecialchars($faculty['name']); ?></td>
                <td><?php echo htmlspecialchars($faculty['email']); ?></td>
                <td><?php echo htmlspecialchars($faculty['contact']); ?></td>
                <td>
                  <button class="action-btn view-btn" onclick="viewFaculty('<?php echo $faculty['faculty_id']; ?>')">
                    <i class="fas fa-eye"></i> View
                  </button>
                  <button class="action-btn edit-btn" onclick="editFaculty('<?php echo $faculty['faculty_id']; ?>')">
                    <i class="fas fa-edit"></i> Edit
                  </button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search']) && empty($error)): ?>
      <div class="no-results">
        <i class="fas fa-user-slash"></i>
        <div>No faculty members found matching your search criteria.</div>
        <div>Try searching by name, ID, email or contact number.</div>
      </div>
    <?php endif; ?>
  </div>

  <script>
    // View faculty details
    function viewFaculty(facultyId) {
      alert('Viewing faculty with ID: ' + facultyId);
      // In a real application, you would redirect to a view page or show a modal
      // window.location.href = 'view_faculty.php?id=' + facultyId;
    }
    
    // Edit faculty details
    function editFaculty(facultyId) {
      alert('Editing faculty with ID: ' + facultyId);
      // In a real application, you would redirect to an edit page
      // window.location.href = 'edit_faculty.php?id=' + facultyId;
    }
    
    // Focus search input on page load
    document.addEventListener('DOMContentLoaded', function() {
      const searchInput = document.querySelector('.search-input');
      if (searchInput && !searchInput.value) {
        searchInput.focus();
      }
      
      // Animate table rows sequentially
      const tableRows = document.querySelectorAll('.results-table tbody tr');
      tableRows.forEach((row, index) => {
        row.style.animation = `fadeInUp 0.4s ease-out ${index * 0.05}s forwards`;
        row.style.opacity = '0';
      });
    });
  </script>
</body>
</html>