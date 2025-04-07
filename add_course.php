<?php
include("db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_id = $_POST['course_id'];
    $course_name = $_POST['course_name'];
    $department = $_POST['department'];
    $credits = $_POST['credits'];

    // Validate credits is a number
    if (!is_numeric($credits) || $credits <= 0) {
        echo "<script>alert('Invalid credits value! Credits must be a positive number.'); window.history.back();</script>";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO courses (course_id, course_name, department, credits) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $course_id, $course_name, $department, $credits);

    if ($stmt->execute()) {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    showNotification('Course added successfully!', 'success');
                });
              </script>";
    } else {
        echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    showNotification('Error adding course: " . addslashes($stmt->error) . "', 'error');
                });
              </script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Add Course</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary-color: #4361ee;
      --secondary-color: #3f37c9;
      --success-color: #4cc9f0;
      --error-color: #f72585;
      --light-color: #f8f9fa;
      --dark-color: #212529;
      --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      --transition: all 0.3s ease;
    }
    
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }
    
    .form-container {
      background: white;
      border-radius: 15px;
      box-shadow: var(--shadow);
      padding: 30px;
      width: 100%;
      max-width: 500px;
      transform: translateY(-20px);
      opacity: 0;
      animation: fadeInUp 0.5s forwards;
      transition: var(--transition);
    }
    
    .form-container:hover {
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
      transform: translateY(-5px);
    }
    
    h2 {
      color: var(--primary-color);
      text-align: center;
      margin-bottom: 25px;
      font-weight: 600;
      position: relative;
    }
    
    h2::after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      width: 50px;
      height: 3px;
      background: var(--success-color);
      border-radius: 3px;
    }
    
    form {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }
    
    input {
      padding: 15px;
      border: 2px solid #e9ecef;
      border-radius: 8px;
      font-size: 16px;
      transition: var(--transition);
    }
    
    input:focus {
      border-color: var(--primary-color);
      outline: none;
      box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
    }
    
    input::placeholder {
      color: #adb5bd;
    }
    
    button {
      background: var(--primary-color);
      color: white;
      border: none;
      padding: 15px;
      border-radius: 8px;
      font-size: 16px;
      font-weight: 500;
      cursor: pointer;
      transition: var(--transition);
      text-transform: uppercase;
      letter-spacing: 1px;
    }
    
    button:hover {
      background: var(--secondary-color);
      transform: translateY(-2px);
    }
    
    button:active {
      transform: translateY(0);
    }
    
    .notification {
      position: fixed;
      top: 20px;
      right: 20px;
      padding: 15px 25px;
      border-radius: 8px;
      color: white;
      font-weight: 500;
      box-shadow: var(--shadow);
      z-index: 1000;
      transform: translateX(100%);
      opacity: 0;
      transition: var(--transition);
    }
    
    .notification.success {
      background: var(--success-color);
    }
    
    .notification.error {
      background: var(--error-color);
    }
    
    .notification.show {
      transform: translateX(0);
      opacity: 1;
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
    
    @keyframes pulse {
      0% {
        transform: scale(1);
      }
      50% {
        transform: scale(1.05);
      }
      100% {
        transform: scale(1);
      }
    }
    
    /* Responsive adjustments */
    @media (max-width: 600px) {
      .form-container {
        padding: 20px;
      }
      
      input, button {
        padding: 12px;
      }
    }
  </style>
</head>
<body>
  <div class="form-container animate__animated animate__fadeInUp">
    <h2>Add New Course</h2>
    <form method="POST" action="add_course.php">
      <input type="text" name="course_id" placeholder="Course ID" required class="animate__animated animate__fadeIn animate__delay-1s">
      <input type="text" name="course_name" placeholder="Course Name" required class="animate__animated animate__fadeIn animate__delay-1s">
      <input type="text" name="department" placeholder="Department" required class="animate__animated animate__fadeIn animate__delay-1s">
      <input type="number" name="credits" placeholder="Credits" required min="1" class="animate__animated animate__fadeIn animate__delay-1s">
      <button type="submit" class="animate__animated animate__fadeIn animate__delay-2s animate__pulse">Add Course</button>
    </form>
  </div>

  <div id="notification" class="notification"></div>

  <script>
    function showNotification(message, type) {
      const notification = document.getElementById('notification');
      notification.textContent = message;
      notification.className = `notification ${type} show`;
      
      setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
          if (type === 'success') {
            window.location.href = 'add_course.php';
          }
        }, 500);
      }, 3000);
    }
    
    // Add focus effects to inputs
    document.querySelectorAll('input').forEach(input => {
      input.addEventListener('focus', function() {
        this.style.transform = 'scale(1.02)';
      });
      
      input.addEventListener('blur', function() {
        this.style.transform = 'scale(1)';
      });
    });
  </script>
</body>
</html>