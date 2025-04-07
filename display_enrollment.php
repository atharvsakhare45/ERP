<?php
include("db_config.php");
$sql = "SELECT * FROM enrollment";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>All Enrollments</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
  <style>
    :root {
      --primary: #4361ee;
      --secondary: #3f37c9;
      --accent: #4895ef;
      --light: #f8f9fa;
      --dark: #212529;
      --success: #4cc9f0;
      --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      --transition: all 0.3s ease;
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
      padding: 40px 20px;
      animation: gradientShift 15s ease infinite;
      background-size: 200% 200%;
    }
    
    @keyframes gradientShift {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }
    
    .container {
      max-width: 1200px;
      width: 100%;
      margin: 0 auto;
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      box-shadow: var(--shadow);
      overflow: hidden;
      padding: 30px;
      animation: fadeIn 0.8s ease-out;
    }
    
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    h1 {
      text-align: center;
      color: var(--dark);
      margin-bottom: 30px;
      font-size: 2.2rem;
      font-weight: 700;
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 15px;
    }
    
    h1::after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      width: 100px;
      height: 4px;
      background: var(--accent);
      border-radius: 2px;
      animation: expandLine 1s ease-out;
    }
    
    @keyframes expandLine {
      from { width: 0; }
      to { width: 100px; }
    }
    
    .table-container {
      overflow-x: auto;
      border-radius: 15px;
      box-shadow: var(--shadow);
      animation: slideUp 0.8s ease-out;
    }
    
    @keyframes slideUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
    }
    
    thead {
      background: var(--primary);
      color: white;
    }
    
    th {
      padding: 15px;
      text-align: left;
      font-weight: 600;
      position: sticky;
      top: 0;
    }
    
    tbody tr {
      transition: var(--transition);
      border-bottom: 1px solid #eee;
    }
    
    tbody tr:hover {
      background-color: rgba(72, 149, 239, 0.1);
      transform: translateX(5px);
    }
    
    td {
      padding: 15px;
      color: #555;
    }
    
    .action-btns {
      display: flex;
      gap: 10px;
    }
    
    .btn {
      padding: 8px 12px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: var(--transition);
      display: inline-flex;
      align-items: center;
      gap: 5px;
      font-size: 0.9rem;
    }
    
    .btn-edit {
      background: #4cc9f0;
      color: white;
    }
    
    .btn-delete {
      background: #f72585;
      color: white;
    }
    
    .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .btn i {
      font-size: 0.9rem;
    }
    
    .no-data {
      text-align: center;
      padding: 30px;
      color: #777;
      font-style: italic;
    }
    
    .back-btn {
      display: inline-block;
      margin-top: 30px;
      padding: 10px 20px;
      background: var(--primary);
      color: white;
      text-decoration: none;
      border-radius: 8px;
      transition: var(--transition);
      font-weight: 500;
    }
    
    .back-btn:hover {
      background: var(--secondary);
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    @media (max-width: 768px) {
      .container {
        padding: 20px;
      }
      
      h1 {
        font-size: 1.8rem;
      }
      
      th, td {
        padding: 10px;
        font-size: 0.9rem;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h1><i class="fas fa-users"></i> All Enrollments</h1>
    
    <div class="table-container">
      <?php if ($result->num_rows > 0): ?>
      <table id="enrollmentsTable">
        <thead>
          <tr>
            <th>Student PRN</th>
            <th>Student Name</th>
            <th>Course ID</th>
            <th>Course Name</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo htmlspecialchars($row['Student_PRN']); ?></td>
            <td><?php echo htmlspecialchars($row['Student_Name']); ?></td>
            <td><?php echo htmlspecialchars($row['Course_ID']); ?></td>
            <td><?php echo htmlspecialchars($row['Course_Name']); ?></td>
            <td>
              <div class="action-btns">
                <button class="btn btn-edit" onclick="editEnrollment('<?php echo $row['Student_PRN']; ?>', '<?php echo $row['Course_ID']; ?>')">
                  <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-delete" onclick="confirmDelete('<?php echo $row['Student_PRN']; ?>', '<?php echo $row['Course_ID']; ?>')">
                  <i class="fas fa-trash-alt"></i> Delete
                </button>
              </div>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
      <?php else: ?>
      <div class="no-data">
        <i class="fas fa-info-circle" style="font-size: 2rem; margin-bottom: 15px;"></i>
        <p>No enrollment records found</p>
      </div>
      <?php endif; ?>
    </div>
    
    <a href="enrollment.php" class="back-btn">
      <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    $(document).ready(function() {
      $('#enrollmentsTable').DataTable({
        responsive: true,
        dom: '<"top"f>rt<"bottom"lip><"clear">',
        language: {
          search: "_INPUT_",
          searchPlaceholder: "Search enrollments...",
        },
        initComplete: function() {
          $('.dataTables_filter input').addClass('search-input');
        }
      });
    });
    
    function editEnrollment(prn, courseId) {
      // Implement edit functionality
      Swal.fire({
        title: 'Edit Enrollment',
        text: `Edit enrollment for PRN: ${prn} and Course ID: ${courseId}`,
        icon: 'info',
        confirmButtonText: 'Continue'
      });
    }
    
    function confirmDelete(prn, courseId) {
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#f72585',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          // AJAX call to delete enrollment
          fetch(`delete_enrollment.php?prn=${prn}&course_id=${courseId}`, {
            method: 'DELETE'
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              Swal.fire(
                'Deleted!',
                'The enrollment has been deleted.',
                'success'
              ).then(() => {
                location.reload();
              });
            } else {
              Swal.fire(
                'Error!',
                'There was a problem deleting the enrollment.',
                'error'
              );
            }
          });
        }
      });
    }
  </script>
</body>
</html>