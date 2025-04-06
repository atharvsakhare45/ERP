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
            $stmt = $conn->prepare("SELECT * FROM faculty WHERE name LIKE ? OR faculty_id LIKE ?");
            $search_param = "%$search_query%";
            $stmt->bind_param("ss", $search_param, $search_param);
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
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f5f5f5;
      margin: 0;
      padding: 0;
    }
    .search-container {
      max-width: 800px;
      margin: 50px auto;
      padding: 30px;
      background: white;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }
    h1 {
      text-align: center;
      color: #333;
      margin-bottom: 30px;
    }
    form {
      display: flex;
      gap: 10px;
      margin-bottom: 30px;
    }
    input[type="text"] {
      flex: 1;
      padding: 12px 15px;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-size: 16px;
    }
    button {
      padding: 12px 25px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s;
    }
    button:hover {
      background-color: #45a049;
    }
    .error {
      color: #ff4444;
      text-align: center;
      margin-bottom: 20px;
    }
    .results-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    .results-table th, .results-table td {
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }
    .results-table th {
      background-color: #f2f2f2;
      font-weight: 500;
    }
    .results-table tr:hover {
      background-color: #f9f9f9;
    }
    .no-results {
      text-align: center;
      color: #666;
      font-style: italic;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div class="search-container">
    <h1>Search Faculty</h1>
    
    <form method="GET" action="search_faculty.php">
      <input type="text" name="search" placeholder="Enter Faculty Name or ID" value="<?php echo htmlspecialchars($search_query); ?>" required>
      <button type="submit">Search</button>
    </form>
    
    <?php if (!empty($error)): ?>
      <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <?php if (!empty($search_results)): ?>
      <table class="results-table">
        <thead>
          <tr>
            <th>Faculty ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Contact</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($search_results as $faculty): ?>
            <tr>
              <td><?php echo htmlspecialchars($faculty['faculty_id']); ?></td>
              <td><?php echo htmlspecialchars($faculty['name']); ?></td>
              <td><?php echo htmlspecialchars($faculty['email']); ?></td>
              <td><?php echo htmlspecialchars($faculty['contact']); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search']) && empty($error)): ?>
      <div class="no-results">No results found for your search.</div>
    <?php endif; ?>
  </div>
</body>
</html>