<?php
include("db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_id = $_POST['course_id'];
    
    // First check if course exists
    $check_sql = "SELECT * FROM courses WHERE course_id = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("s", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Course exists, proceed with deletion
        $delete_sql = "DELETE FROM courses WHERE course_id = ?";
        $stmt = $conn->prepare($delete_sql);
        $stmt->bind_param("s", $course_id);
        
        if ($stmt->execute()) {
            echo "<script>
                    showAlert('success', 'Course deleted successfully');
                    setTimeout(() => { window.location.href = 'courses.php'; }, 1500);
                  </script>";
        } else {
            echo "<script>showAlert('error', 'Error deleting course: " . addslashes($conn->error) . "');</script>";
        }
    } else {
        echo "<script>showAlert('error', 'Course not found');</script>";
    }
    
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Delete Course</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary: #ff4757;
      --primary-light: #ff6b81;
      --primary-dark: #ff0000;
      --accent: #ff6348;
      --light: #f8f9fa;
      --dark: #2f3542;
      --gray: #747d8c;
      --radius: 12px;
      --shadow-sm: 0 4px 20px rgba(0, 0, 0, 0.1);
      --shadow-md: 0 10px 30px -15px rgba(0, 0, 0, 0.2);
      --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #f1f2f6 0%, #dfe4ea 100%);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
      overflow-x: hidden;
    }

    .floating-bg {
      position: fixed;
      width: 300px;
      height: 300px;
      background: linear-gradient(135deg, rgba(255, 71, 87, 0.1) 0%, rgba(255, 99, 72, 0.1) 100%);
      border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
      z-index: -1;
      animation: float 15s infinite ease-in-out;
      filter: blur(30px);
      opacity: 0.7;
    }

    .floating-bg:nth-child(1) {
      top: -100px;
      left: -100px;
    }

    .floating-bg:nth-child(2) {
      bottom: -100px;
      right: -100px;
      animation-delay: 2s;
    }

    @keyframes float {
      0%, 100% {
        transform: translate(0, 0) rotate(0deg);
      }
      25% {
        transform: translate(50px, 50px) rotate(5deg);
      }
      50% {
        transform: translate(0, 100px) rotate(0deg);
      }
      75% {
        transform: translate(-50px, 50px) rotate(-5deg);
      }
    }

    .form-container {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      border-radius: var(--radius);
      box-shadow: var(--shadow-md);
      padding: 40px;
      width: 100%;
      max-width: 500px;
      text-align: center;
      transform: translateY(0);
      opacity: 1;
      transition: var(--transition);
      border: 1px solid rgba(255, 255, 255, 0.2);
      animation: fadeInUp 0.6s ease-out;
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

    h2 {
      color: var(--primary);
      margin-bottom: 1.5rem;
      font-size: 2rem;
      font-weight: 700;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    .warning-message {
      background: rgba(255, 71, 87, 0.1);
      color: var(--primary);
      padding: 15px;
      border-radius: var(--radius);
      margin-bottom: 2rem;
      font-weight: 500;
      border-left: 4px solid var(--primary);
      animation: pulseWarning 2s infinite;
    }

    @keyframes pulseWarning {
      0%, 100% {
        box-shadow: 0 0 0 0 rgba(255, 71, 87, 0.1);
      }
      50% {
        box-shadow: 0 0 0 10px rgba(255, 71, 87, 0);
      }
    }

    form {
      display: flex;
      flex-direction: column;
      gap: 1.5rem;
    }

    .input-group {
      position: relative;
    }

    input {
      width: 100%;
      padding: 15px 0;
      border: none;
      border-bottom: 2px solid #ddd;
      font-size: 16px;
      transition: var(--transition);
      outline: none;
      background: transparent;
    }

    input:focus {
      border-bottom-color: var(--primary);
    }

    .underline {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 0;
      height: 2px;
      background: var(--primary);
      transition: var(--transition);
    }

    input:focus ~ .underline {
      width: 100%;
    }

    button {
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: white;
      border: none;
      padding: 15px;
      border-radius: var(--radius);
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: var(--transition);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      box-shadow: 0 4px 15px rgba(255, 71, 87, 0.3);
    }

    button:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(255, 71, 87, 0.4);
    }

    button:active {
      transform: translateY(0);
    }

    .loading-spinner {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      backdrop-filter: blur(5px);
      z-index: 1000;
      justify-content: center;
      align-items: center;
    }

    .loading-spinner::after {
      content: "";
      width: 50px;
      height: 50px;
      border: 5px solid rgba(255, 255, 255, 0.3);
      border-radius: 50%;
      border-top-color: var(--primary);
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      to {
        transform: rotate(360deg);
      }
    }

    .alert {
      position: fixed;
      top: 20px;
      right: 20px;
      padding: 15px 25px;
      border-radius: var(--radius);
      color: white;
      font-weight: 500;
      box-shadow: var(--shadow-md);
      display: flex;
      align-items: center;
      gap: 10px;
      transform: translateX(150%);
      transition: transform 0.3s ease;
      z-index: 1000;
    }

    .alert.success {
      background: linear-gradient(135deg, #2ed573, #20bf6b);
    }

    .alert.error {
      background: linear-gradient(135deg, var(--primary), var(--accent));
    }

    .alert.show {
      transform: translateX(0);
    }

    @media (max-width: 768px) {
      .form-container {
        padding: 30px;
      }
      
      h2 {
        font-size: 1.5rem;
      }
    }
  </style>
</head>
<body>
  <div class="floating-bg"></div>
  <div class="floating-bg" style="animation-delay: 2s"></div>

  <div class="form-container">
    <h2>
      <i class="fas fa-exclamation-triangle"></i>
      Delete Course
    </h2>
    
    <div class="warning-message">
      <i class="fas fa-radiation"></i> Warning: This action is permanent and cannot be undone.
    </div>

    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" id="deleteForm">
      <div class="input-group">
        <input 
          type="text" 
          name="course_id" 
          placeholder="Enter Course ID" 
          required
          autocomplete="off"
        >
        <span class="underline"></span>
      </div>
      <button type="submit">
        <i class="fas fa-trash-alt"></i> Delete Course
      </button>
    </form>
  </div>

  <div class="loading-spinner"></div>

  <div id="alertContainer"></div>

  <script>
    // Show alert function
    function showAlert(type, message) {
      const alertContainer = document.getElementById('alertContainer');
      const alert = document.createElement('div');
      alert.className = `alert ${type}`;
      
      const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
      alert.innerHTML = `<i class="fas ${icon}"></i> ${message}`;
      
      alertContainer.appendChild(alert);
      
      // Trigger reflow to enable animation
      void alert.offsetWidth;
      
      alert.classList.add('show');
      
      // Remove alert after 3 seconds
      setTimeout(() => {
        alert.classList.remove('show');
        setTimeout(() => {
          alert.remove();
        }, 300);
      }, 3000);
    }

    document.addEventListener('DOMContentLoaded', () => {
      const form = document.getElementById('deleteForm');
      const spinner = document.querySelector('.loading-spinner');
      const courseInput = form.elements['course_id'];

      // Focus animation
      courseInput.addEventListener('focus', () => {
        document.querySelector('.underline').style.width = '100%';
      });

      courseInput.addEventListener('blur', () => {
        if (!courseInput.value) {
          document.querySelector('.underline').style.width = '0';
        }
      });

      form.addEventListener('submit', (e) => {
        e.preventDefault();
        
        const courseId = courseInput.value.trim();
        
        if (!courseId) {
          showAlert('error', 'Please enter a course ID');
          return;
        }
        
        if (confirm(`Are you absolutely sure you want to delete course ${courseId}?\n\nThis will permanently remove all course data.`)) {
          spinner.style.display = 'flex';
          
          // Submit the form after confirmation
          setTimeout(() => {
            form.submit();
          }, 500);
        }
      });
    });
  </script>
</body>
</html>