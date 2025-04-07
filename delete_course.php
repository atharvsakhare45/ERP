<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Delete Course</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    :root {
      --primary: #ff4757;
      --primary-dark: #ff2d42;
      --accent: #ff6b81;
      --background: #f8f9fa;
      --text: #2d3436;
      --radius: 12px;
      --shadow: 0 10px 30px -15px rgba(0, 0, 0, 0.1);
      --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
      margin: 0;
      background: var(--background);
      font-family: 'Poppins', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      overflow: hidden;
    }

    .floating-bg {
      position: absolute;
      width: 400px;
      height: 400px;
      background: linear-gradient(45deg, var(--primary), var(--accent));
      border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
      filter: blur(60px);
      opacity: 0.1;
      animation: float 15s infinite ease-in-out;
      z-index: -1;
    }

    @keyframes float {
      0%, 100% { transform: translate(0, 0) rotate(0deg); }
      25% { transform: translate(50px, 50px) rotate(5deg); }
      50% { transform: translate(0, 100px) rotate(0deg); }
      75% { transform: translate(-50px, 50px) rotate(-5deg); }
    }

    .form-container {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      padding: 40px;
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      width: 100%;
      max-width: 400px;
      transform: translateY(20px);
      opacity: 0;
      animation: slideUp 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
      border: 1px solid rgba(255, 255, 255, 0.2);
    }

    @keyframes slideUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    h2 {
      text-align: center;
      color: var(--primary);
      margin-bottom: 30px;
      font-size: 1.8rem;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    .input-group {
      position: relative;
      margin-bottom: 25px;
    }

    input {
      width: 100%;
      padding: 15px;
      border: 2px solid #eee;
      border-radius: var(--radius);
      font-size: 1rem;
      transition: var(--transition);
      background: rgba(255, 255, 255, 0.9);
    }

    input:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 4px 15px rgba(255, 71, 87, 0.2);
    }

    .underline {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 2px;
      background: var(--primary);
      transform: scaleX(0);
      transition: var(--transition);
    }

    input:focus ~ .underline {
      transform: scaleX(1);
    }

    button {
      width: 100%;
      padding: 15px;
      background: var(--primary);
      color: white;
      border: none;
      border-radius: var(--radius);
      font-weight: 600;
      cursor: pointer;
      transition: var(--transition);
      position: relative;
      overflow: hidden;
    }

    button:hover {
      background: var(--primary-dark);
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(255, 71, 87, 0.3);
    }

    button::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(
        120deg,
        transparent,
        rgba(255, 255, 255, 0.3),
        transparent
      );
      transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    button:hover::before {
      left: 100%;
    }

    .warning-message {
      text-align: center;
      color: #666;
      margin-bottom: 25px;
      animation: fadeIn 0.6s ease-out;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .confirmation-dialog {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: white;
      padding: 30px;
      border-radius: var(--radius);
      box-shadow: var(--shadow);
      text-align: center;
      animation: scaleIn 0.3s ease-out;
    }

    @keyframes scaleIn {
      from { transform: translate(-50%, -50%) scale(0.8); opacity: 0; }
      to { transform: translate(-50%, -50%) scale(1); opacity: 1; }
    }

    .loading-spinner {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 40px;
      height: 40px;
      border: 4px solid #f3f3f3;
      border-top: 4px solid var(--primary);
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% { transform: translate(-50%, -50%) rotate(0deg); }
      100% { transform: translate(-50%, -50%) rotate(360deg); }
    }

    @media (max-width: 480px) {
      .form-container {
        padding: 30px;
        margin: 15px;
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
      Warning: This action cannot be undone. Please confirm the course ID carefully.
    </div>

    <form method="POST" action="" id="deleteForm">
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
      <button type="submit">Delete Course</button>
    </form>
  </div>

  <div class="loading-spinner"></div>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // Form submission handling
      const form = document.getElementById('deleteForm');
      const spinner = document.querySelector('.loading-spinner');

      form.addEventListener('submit', (e) => {
        e.preventDefault();
        spinner.style.display = 'block';
        
        // Simulate processing delay
        setTimeout(() => {
          form.submit();
          spinner.style.display = 'none';
        }, 1500);
      });

      // Input animation
      const input = document.querySelector('input');
      input.addEventListener('focus', () => {
        input.parentElement.querySelector('.underline').style.transform = 'scaleX(1)';
      });
      input.addEventListener('blur', () => {
        if (!input.value) {
          input.parentElement.querySelector('.underline').style.transform = 'scaleX(0)';
        }
      });
    });
  </script>
</body>
</html>