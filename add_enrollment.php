<?php
include("db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_prn = $_POST['student_prn'];
    $student_name = $_POST['student_name'];
    $course_id = $_POST['course_id'];
    $course_name = $_POST['course_name'];

    // Prepared statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO enrollment (Student_PRN, Student_Name, Course_ID, Course_Name) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $student_prn, $student_name, $course_id, $course_name);

    if ($stmt->execute()) {
        $success_message = "Enrollment added successfully!";
    } else {
        $error_message = "Error: " . $conn->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Enrollment</title>
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
      max-width: 600px;
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
    }

    .input-group {
      position: relative;
    }

    input {
      width: 100%;
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

    label {
      position: absolute;
      left: 20px;
      top: 15px;
      color: #666;
      transition: all 0.3s;
      pointer-events: none;
      background: #f8f9fa;
      padding: 0 5px;
    }

    input:focus + label,
    input:not(:placeholder-shown) + label {
      top: -10px;
      left: 15px;
      font-size: 12px;
      color: var(--primary);
      background: white;
    }

    button {
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      color: white;
      border: none;
      padding: 15px;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      margin-top: 10px;
    }

    button:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 20px rgba(67, 97, 238, 0.3);
    }

    button:active {
      transform: translateY(0);
    }

    .alert {
      padding: 15px;
      border-radius: 10px;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 10px;
      animation: fadeIn 0.5s;
    }

    .alert-success {
      background: rgba(76, 201, 240, 0.1);
      border: 1px solid var(--success);
      color: var(--success);
    }

    .alert-error {
      background: rgba(239, 35, 60, 0.1);
      border: 1px solid var(--error);
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

    @media (max-width: 768px) {
      .container {
        padding: 30px;
      }
      
      h1 {
        font-size: 1.8rem;
      }
      
      input {
        padding: 12px 15px;
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
      
      form {
        gap: 15px;
      }
    }
  </style>
</head>
<body>
  <div class="container animate__animated animate__fadeInUp">
    <h1><i class="fas fa-user-graduate"></i> Student Enrollment</h1>
    
    <?php if (isset($success_message)): ?>
      <div class="alert alert-success animate__animated animate__fadeIn">
        <i class="fas fa-check-circle"></i>
        <?php echo $success_message; ?>
      </div>
    <?php endif; ?>
    
    <?php if (isset($error_message)): ?>
      <div class="alert alert-error animate__animated animate__fadeIn">
        <i class="fas fa-exclamation-circle"></i>
        <?php echo $error_message; ?>
      </div>
    <?php endif; ?>
    
    <form method="POST">
      <div class="input-group">
        <input type="text" name="student_prn" id="student_prn" placeholder=" " required>
        <label for="student_prn">Student PRN</label>
      </div>
      
      <div class="input-group">
        <input type="text" name="student_name" id="student_name" placeholder=" " required>
        <label for="student_name">Student Name</label>
      </div>
      
      <div class="input-group">
        <input type="text" name="course_id" id="course_id" placeholder=" " required>
        <label for="course_id">Course ID</label>
      </div>
      
      <div class="input-group">
        <input type="text" name="course_name" id="course_name" placeholder=" " required>
        <label for="course_name">Course Name</label>
      </div>
      
      <button type="submit">
        <i class="fas fa-user-plus"></i> Enroll Student
      </button>
    </form>
  </div>

  <script>
    // Add animation to form elements
    document.addEventListener('DOMContentLoaded', function() {
      const inputs = document.querySelectorAll('.input-group');
      inputs.forEach((input, index) => {
        input.style.animationDelay = `${index * 0.1}s`;
      });
      
      // Add floating labels functionality
      const textInputs = document.querySelectorAll('input[type="text"]');
      textInputs.forEach(input => {
        input.addEventListener('focus', function() {
          const label = this.nextElementSibling;
          label.style.color = '#4361ee';
        });
        
        input.addEventListener('blur', function() {
          if (!this.value) {
            const label = this.nextElementSibling;
            label.style.color = '#666';
          }
        });
      });
    });
  </script>
</body>
</html>