<?php
include("db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $faculty_id = $_POST['faculty_id'];

    $stmt = $conn->prepare("DELETE FROM faculty WHERE faculty_id = ?");
    $stmt->bind_param("s", $faculty_id);

    if ($stmt->execute()) {
        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Faculty deleted successfully!',
                    showConfirmButton: true,
                    timer: 2000
                }).then(() => {
                    window.location.href = 'delete_faculty.php';
                });
              </script>";
        exit;
    } else {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Error deleting faculty: " . addslashes($stmt->error) . "'
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
  <title>Delete Faculty</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <style>
    :root {
      --primary: #ef4444;
      --primary-dark: #dc2626;
      --primary-light: #fee2e2;
      --text: #1f2937;
      --light: #f9fafb;
      --gray: #6b7280;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: linear-gradient(135deg, #f8fafc, #f1f5f9);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    .delete-container {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      padding: 40px;
      width: 100%;
      max-width: 480px;
      border: 1px solid rgba(255, 255, 255, 0.3);
      transform: translateY(20px);
      opacity: 0;
      animation: fadeInUp 0.6s ease-out forwards;
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

    h1 {
      text-align: center;
      color: var(--primary-dark);
      margin-bottom: 30px;
      font-size: 28px;
      font-weight: 700;
      position: relative;
    }

    h1::after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 50%;
      transform: translateX(-50%);
      width: 60px;
      height: 4px;
      background: linear-gradient(90deg, var(--primary), var(--primary-dark));
      border-radius: 2px;
    }

    .delete-form {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .form-group {
      position: relative;
    }

    .form-group input {
      width: 100%;
      padding: 15px;
      border: 2px solid rgba(0, 0, 0, 0.1);
      border-radius: 10px;
      font-size: 16px;
      background: rgba(255, 255, 255, 0.8);
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .form-group input:focus {
      border-color: var(--primary);
      box-shadow: 0 4px 20px rgba(239, 68, 68, 0.2);
      outline: none;
    }

    .delete-btn {
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: white;
      border: none;
      padding: 16px;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 10px;
      box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
      position: relative;
      overflow: hidden;
    }

    .delete-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(239, 68, 68, 0.4);
    }

    .delete-btn:active {
      transform: translateY(1px);
    }

    .delete-btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(
        90deg,
        transparent,
        rgba(255, 255, 255, 0.2),
        transparent
      );
      transition: 0.5s;
    }

    .delete-btn:hover::before {
      left: 100%;
    }

    .warning-text {
      text-align: center;
      color: var(--gray);
      font-size: 14px;
      margin-top: 15px;
      animation: pulse 2s infinite;
    }

    @keyframes pulse {
      0% { opacity: 0.8; }
      50% { opacity: 1; }
      100% { opacity: 0.8; }
    }

    /* Responsive styles */
    @media (max-width: 768px) {
      .delete-container {
        padding: 30px;
      }
      
      h1 {
        font-size: 24px;
      }
    }

    @media (max-width: 480px) {
      .delete-container {
        padding: 25px 20px;
      }
      
      h1 {
        font-size: 22px;
        margin-bottom: 25px;
      }
      
      .form-group input {
        padding: 12px;
      }
      
      .delete-btn {
        padding: 14px;
      }
    }
  </style>
</head>
<body>
  <div class="delete-container">
    <h1><i class="fas fa-user-minus"></i> Delete Faculty</h1>
    <form method="POST" class="delete-form">
      <div class="form-group">
        <input type="text" name="faculty_id" placeholder="Enter Faculty ID" required>
      </div>
      <button type="submit" class="delete-btn">
        <i class="fas fa-trash-alt"></i> Delete Faculty
      </button>
      <p class="warning-text">Warning: This action cannot be undone!</p>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
  <script>
    // Add animation to form elements when page loads
    document.addEventListener('DOMContentLoaded', function() {
      // Animate form elements sequentially
      const formGroups = document.querySelectorAll('.form-group, .delete-btn, .warning-text');
      formGroups.forEach((element, index) => {
        element.style.animation = `fadeInUp 0.5s ease-out ${index * 0.1 + 0.3}s forwards`;
        element.style.opacity = '0';
      });
      
      // Add confirmation dialog
      const form = document.querySelector('.delete-form');
      form.addEventListener('submit', function(e) {
        const facultyId = document.querySelector('input[name="faculty_id"]').value;
        if (!facultyId) return;
        
        e.preventDefault();
        
        Swal.fire({
          title: 'Are you sure?',
          text: `You are about to delete faculty member with ID: ${facultyId}`,
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#ef4444',
          cancelButtonColor: '#6b7280',
          confirmButtonText: 'Yes, delete it!',
          cancelButtonText: 'Cancel',
          reverseButtons: true
        }).then((result) => {
          if (result.isConfirmed) {
            form.submit();
          }
        });
      });
    });
  </script>
</body>
</html>