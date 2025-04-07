<?php
session_start();
include("db_config.php");

$errors = [];
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $faculty_id = $_POST['faculty_id'] ?? '';
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $contact = $_POST['contact'] ?? '';

    // Validation
    if (empty($faculty_id)) $errors[] = "Faculty ID is required";
    if (empty($name)) $errors[] = "Faculty Name is required";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid Email";
    if (empty($contact)) $errors[] = "Contact number is required";

    // If no errors, insert data
    if (empty($errors)) {
        try {
            $stmt = $conn->prepare("INSERT INTO faculty (faculty_id, name, email, contact) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $faculty_id, $name, $email, $contact);
            $stmt->execute();
            
            $success = "Faculty added successfully!";
            // Clear form fields after successful submission
            $faculty_id = $name = $email = $contact = '';
        } catch (Exception $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Faculty</title>
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
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    .form-container {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      border-radius: 20px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
      padding: 40px;
      width: 100%;
      max-width: 600px;
      border: 1px solid rgba(255, 255, 255, 0.3);
      transform: translateY(20px);
      opacity: 0;
      animation: fadeInUp 0.6s ease-out forwards;
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
      background: linear-gradient(90deg, var(--primary), var(--secondary));
      border-radius: 2px;
    }

    .faculty-form {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }

    .form-group {
      position: relative;
    }

    .form-group label {
      position: absolute;
      left: 15px;
      top: 15px;
      color: var(--gray);
      transition: all 0.3s ease;
      pointer-events: none;
      background: white;
      padding: 0 5px;
    }

    .form-group input {
      width: 100%;
      padding: 15px;
      border: 1px solid rgba(0, 0, 0, 0.1);
      border-radius: 10px;
      font-size: 16px;
      background: rgba(255, 255, 255, 0.8);
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .form-group input:focus {
      border-color: var(--primary);
      box-shadow: 0 4px 20px rgba(99, 102, 241, 0.2);
      outline: none;
    }

    .form-group input:focus + label,
    .form-group input:not(:placeholder-shown) + label {
      top: -10px;
      left: 10px;
      font-size: 12px;
      color: var(--primary);
      background: white;
    }

    .submit-btn {
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      color: white;
      border: none;
      padding: 15px;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 10px;
      box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
      position: relative;
      overflow: hidden;
    }

    .submit-btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4);
    }

    .submit-btn:active {
      transform: translateY(0);
    }

    .submit-btn::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, rgba(255,255,255,0.2), rgba(255,255,255,0));
      transform: translateX(-100%);
      transition: transform 0.4s ease;
    }

    .submit-btn:hover::after {
      transform: translateX(0);
    }

    .error-message {
      background: rgba(239, 68, 68, 0.1);
      border-left: 4px solid var(--danger);
      padding: 15px;
      border-radius: 8px;
      margin-bottom: 20px;
      color: var(--danger);
      animation: shake 0.5s ease-in-out;
    }

    .error-message p {
      margin-bottom: 5px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .error-message p:last-child {
      margin-bottom: 0;
    }

    .success-message {
      background: rgba(16, 185, 129, 0.1);
      border-left: 4px solid var(--success);
      padding: 15px;
      border-radius: 8px;
      margin-bottom: 20px;
      color: var(--success);
      display: flex;
      align-items: center;
      gap: 10px;
      animation: fadeIn 0.5s ease-out;
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
      .form-container {
        padding: 30px;
      }
      
      h1 {
        font-size: 24px;
      }
    }

    @media (max-width: 480px) {
      .form-container {
        padding: 25px 20px;
      }
      
      h1 {
        font-size: 22px;
        margin-bottom: 25px;
      }
      
      .faculty-form {
        gap: 15px;
      }
      
      .form-group input {
        padding: 12px;
      }
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h1><i class="fas fa-user-plus"></i> Add Faculty Member</h1>

    <?php if (!empty($errors)): ?>
      <div class="error-message">
        <?php foreach ($errors as $error): ?>
          <p><i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
      <div class="success-message">
        <i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="add_faculty.php" class="faculty-form">
      <div class="form-group">
        <input type="text" name="faculty_id" id="faculty_id" placeholder=" " value="<?= htmlspecialchars($faculty_id ?? '') ?>" required>
        <label for="faculty_id">Faculty ID</label>
      </div>
      
      <div class="form-group">
        <input type="text" name="name" id="name" placeholder=" " value="<?= htmlspecialchars($name ?? '') ?>" required>
        <label for="name">Full Name</label>
      </div>
      
      <div class="form-group">
        <input type="email" name="email" id="email" placeholder=" " value="<?= htmlspecialchars($email ?? '') ?>" required>
        <label for="email">Email Address</label>
      </div>
      
      <div class="form-group">
        <input type="tel" name="contact" id="contact" placeholder=" " value="<?= htmlspecialchars($contact ?? '') ?>" required>
        <label for="contact">Contact Number</label>
      </div>
      
      <button type="submit" class="submit-btn">
        <i class="fas fa-user-plus"></i> Add Faculty Member
      </button>
    </form>
  </div>

  <script>
    // Add animation to form elements when page loads
    document.addEventListener('DOMContentLoaded', function() {
      // Animate form groups sequentially
      const formGroups = document.querySelectorAll('.form-group');
      formGroups.forEach((group, index) => {
        group.style.animation = `fadeInUp 0.5s ease-out ${index * 0.1 + 0.3}s forwards`;
        group.style.opacity = '0';
      });
      
      // Animate submit button
      const submitBtn = document.querySelector('.submit-btn');
      submitBtn.style.animation = `fadeInUp 0.5s ease-out ${formGroups.length * 0.1 + 0.4}s forwards`;
      submitBtn.style.opacity = '0';
      
      // Add floating labels functionality
      document.querySelectorAll('input').forEach(element => {
        element.addEventListener('focus', function() {
          const label = this.parentElement.querySelector('label');
          label.style.color = 'var(--primary)';
        });
        
        element.addEventListener('blur', function() {
          const label = this.parentElement.querySelector('label');
          label.style.color = 'var(--gray)';
        });
      });
    });
  </script>
</body>
</html>