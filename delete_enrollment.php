<?php
include("db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_prn = $_POST['student_prn'];
    $course_id = $_POST['course_id'];

    $sql = "DELETE FROM enrollment WHERE Student_PRN='$student_prn' AND Course_ID='$course_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Enrollment deleted successfully',
                    showConfirmButton: true,
                    timer: 2000
                }).then(() => {
                    window.location.href='enrollment.php';
                });
              </script>";
    } else {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Error deleting enrollment: " . addslashes($conn->error) . "',
                    showConfirmButton: true
                });
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Delete Enrollment</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
  <style>
    :root {
      --primary: #4361ee;
      --secondary: #3f37c9;
      --danger: #f72585;
      --light: #f8f9fa;
      --dark: #212529;
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
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
      animation: gradientShift 15s ease infinite;
      background-size: 200% 200%;
    }
    
    @keyframes gradientShift {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }
    
    .container {
      max-width: 500px;
      width: 100%;
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      box-shadow: var(--shadow);
      overflow: hidden;
      padding: 40px;
      animation: fadeIn 0.8s ease-out;
    }
    
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    h1 {
      text-align: center;
      color: var(--danger);
      margin-bottom: 30px;
      font-size: 2rem;
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
      background: var(--danger);
      border-radius: 2px;
      animation: expandLine 1s ease-out;
    }
    
    @keyframes expandLine {
      from { width: 0; }
      to { width: 80px; }
    }
    
    form {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }
    
    .input-group {
      position: relative;
    }
    
    input {
      width: 100%;
      padding: 15px 20px 15px 45px;
      border: 2px solid #e9ecef;
      border-radius: 10px;
      font-size: 1rem;
      transition: var(--transition);
      box-shadow: var(--shadow);
    }
    
    input:focus {
      outline: none;
      border-color: var(--danger);
      box-shadow: 0 0 0 3px rgba(247, 37, 133, 0.2);
    }
    
    .input-icon {
      position: absolute;
      left: 15px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--danger);
      font-size: 1.2rem;
    }
    
    button {
      padding: 15px;
      background: var(--danger);
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 1.1rem;
      font-weight: 600;
      cursor: pointer;
      transition: var(--transition);
      box-shadow: var(--shadow);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }
    
    button:hover {
      background: #d91a6d;
      transform: translateY(-3px);
      box-shadow: 0 10px 20px rgba(247, 37, 133, 0.3);
    }
    
    button i {
      font-size: 1.2rem;
      transition: var(--transition);
    }
    
    button:hover i {
      transform: scale(1.1);
    }
    
    .warning-message {
      text-align: center;
      color: #6c757d;
      margin-top: 20px;
      font-size: 0.9rem;
      animation: fadeIn 1s ease-out;
    }
    
    @media (max-width: 576px) {
      .container {
        padding: 30px 20px;
      }
      
      h1 {
        font-size: 1.8rem;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <h1><i class="fas fa-user-minus"></i> Delete Enrollment</h1>
    <form method="POST">
      <div class="input-group">
        <i class="fas fa-id-card input-icon"></i>
        <input type="text" name="student_prn" placeholder="Student PRN" required>
      </div>
      
      <div class="input-group">
        <i class="fas fa-book input-icon"></i>
        <input type="text" name="course_id" placeholder="Course ID" required>
      </div>
      
      <button type="submit">
        <i class="fas fa-trash-alt"></i> Delete Enrollment
      </button>
    </form>
    
    <p class="warning-message">
      <i class="fas fa-exclamation-triangle"></i> Warning: This action cannot be undone
    </p>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>