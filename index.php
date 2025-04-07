<?php
session_start();
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student Sign-In | PCCOE</title>
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
      --warning: #f59e0b;
      --danger: #ef4444;
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: linear-gradient(135deg, #f8fafc, #e2e8f0);
      color: var(--dark);
      min-height: 100vh;
      overflow-x: hidden;
    }

    .container {
      display: flex;
      flex-wrap: wrap;
      min-height: 100vh;
      position: relative;
    }

    .banner {
      flex: 1;
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px;
      position: relative;
      overflow: hidden;
      z-index: 1;
    }

    .banner::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
      animation: rotate 20s linear infinite;
      z-index: -1;
    }

    .banner img {
      max-width: 100%;
      border-radius: 20px;
      box-shadow: 0 12px 30px rgba(0,0,0,0.2);
      transform: perspective(1000px) rotateY(-10deg);
      transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      animation: float 6s ease-in-out infinite;
    }

    .banner:hover img {
      transform: perspective(1000px) rotateY(0deg) translateY(-10px);
    }

    .login-section {
      flex: 1;
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(10px);
      padding: 60px 40px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      position: relative;
      z-index: 2;
      border-left: 1px solid rgba(255, 255, 255, 0.3);
    }

    .logo {
      height: 100px;
      margin: 10px 0;
      filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1));
      transition: all 0.3s ease;
      animation: fadeInUp 0.8s ease-out;
    }

    .logo:hover {
      transform: scale(1.05);
    }

    .title {
      font-size: 28px;
      font-weight: 600;
      color: var(--primary-dark);
      margin: 15px 0;
      text-align: center;
      position: relative;
      animation: fadeInUp 0.8s ease-out 0.2s both;
    }

    .title::after {
      content: '';
      position: absolute;
      bottom: -8px;
      left: 50%;
      transform: translateX(-50%);
      width: 60px;
      height: 3px;
      background: linear-gradient(90deg, var(--primary), var(--secondary));
      border-radius: 3px;
    }

    .highlight {
      color: var(--accent);
      font-weight: 700;
    }

    .error-message {
      color: var(--danger);
      margin: 15px 0;
      text-align: center;
      font-weight: 500;
      padding: 12px 20px;
      background: rgba(239, 68, 68, 0.1);
      border-radius: 8px;
      border-left: 4px solid var(--danger);
      animation: shake 0.5s ease-in-out;
    }

    form {
      width: 100%;
      max-width: 400px;
      display: flex;
      flex-direction: column;
      gap: 25px;
      margin-top: 20px;
      animation: fadeIn 0.8s ease-out 0.4s both;
    }

    .input-group {
      position: relative;
    }

    label {
      display: block;
      margin-bottom: 8px;
      font-weight: 500;
      color: var(--dark);
      transition: all 0.3s ease;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 14px 16px;
      border: 1px solid rgba(0,0,0,0.1);
      border-radius: 12px;
      outline: none;
      font-size: 15px;
      background: rgba(255,255,255,0.8);
      box-shadow: 0 4px 15px rgba(0,0,0,0.05);
      transition: all 0.3s ease;
    }

    input[type="text"]:focus,
    input[type="password"]:focus {
      border-color: var(--primary);
      box-shadow: 0 4px 20px rgba(99, 102, 241, 0.2);
    }

    .toggle-password {
      position: absolute;
      right: 15px;
      top: 42px;
      cursor: pointer;
      color: var(--gray);
      transition: all 0.3s ease;
    }

    .toggle-password:hover {
      color: var(--primary);
    }

    .btn {
      background: linear-gradient(135deg, var(--primary), var(--secondary));
      color: #fff;
      padding: 14px;
      border: none;
      border-radius: 12px;
      font-size: 16px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
      position: relative;
      overflow: hidden;
    }

    .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
    }

    .btn:active {
      transform: translateY(0);
    }

    .btn::after {
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

    .btn:hover::after {
      transform: translateX(0);
    }

    .help-links {
      display: flex;
      justify-content: space-between;
      font-size: 14px;
      margin-top: 10px;
    }

    .help-links a {
      color: var(--gray);
      text-decoration: none;
      transition: all 0.3s ease;
      position: relative;
    }

    .help-links a::after {
      content: '';
      position: absolute;
      bottom: -2px;
      left: 0;
      width: 0;
      height: 1px;
      background: var(--primary);
      transition: width 0.3s ease;
    }

    .help-links a:hover {
      color: var(--primary);
    }

    .help-links a:hover::after {
      width: 100%;
    }

    .app-links {
      display: flex;
      justify-content: center;
      gap: 15px;
      margin-top: 30px;
    }

    .app-links a {
      display: inline-block;
      transition: all 0.3s ease;
    }

    .app-links img {
      height: 45px;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      transition: all 0.3s ease;
    }

    .app-links a:hover img {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    footer {
      text-align: center;
      padding: 20px;
      background: rgba(255,255,255,0.8);
      font-size: 14px;
      color: var(--gray);
      backdrop-filter: blur(5px);
      border-top: 1px solid rgba(255,255,255,0.5);
    }

    .eduplus {
      color: var(--primary);
      font-weight: 600;
      position: relative;
    }

    .eduplus::after {
      content: '';
      position: absolute;
      bottom: -2px;
      left: 0;
      width: 100%;
      height: 2px;
      background: linear-gradient(90deg, var(--primary), var(--secondary));
      transform: scaleX(0);
      transform-origin: right;
      transition: transform 0.3s ease;
    }

    .eduplus:hover::after {
      transform: scaleX(1);
      transform-origin: left;
    }

    .social-icons {
      margin-top: 15px;
      display: flex;
      justify-content: center;
      gap: 15px;
    }

    .social-icon {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 16px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .social-icon:hover {
      transform: translateY(-3px) scale(1.1);
    }

    .youtube { background: #ff0000; }
    .facebook { background: #3b5998; }
    .instagram { background: linear-gradient(45deg, #405de6, #5851db, #833ab4, #c13584, #e1306c, #fd1d1d); }
    .twitter { background: #1da1f2; }

    /* Animations */
    @keyframes rotate {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    @keyframes float {
      0%, 100% { transform: perspective(1000px) rotateY(-10deg) translateY(0); }
      50% { transform: perspective(1000px) rotateY(-10deg) translateY(-15px); }
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

    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      20%, 60% { transform: translateX(-5px); }
      40%, 80% { transform: translateX(5px); }
    }

    /* Responsive styles */
    @media (max-width: 992px) {
      .banner {
        padding: 30px;
      }
      
      .login-section {
        padding: 40px 30px;
      }
    }

    @media (max-width: 768px) {
      .container {
        flex-direction: column;
      }

      .banner,
      .login-section {
        flex: unset;
        width: 100%;
        padding: 30px 20px;
      }

      .banner {
        padding-top: 50px;
      }

      .banner img {
        max-width: 80%;
      }

      .login-section {
        border-left: none;
        border-top: 1px solid rgba(255,255,255,0.3);
      }

      form {
        max-width: 100%;
      }
    }

    @media (max-width: 480px) {
      .title {
        font-size: 24px;
      }

      .logo {
        height: 80px;
      }

      .help-links {
        flex-direction: column;
        align-items: center;
        gap: 10px;
      }

      .app-links {
        flex-direction: column;
        align-items: center;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- Left Section: Banner -->
    <div class="banner">
      <img src="img/pccoe_img.jpeg" alt="PCCOE Campus" />
    </div>

    <!-- Right Section: Login Form -->
    <div class="login-section">
      <h2 class="title">Pimpri Chinchwad College Of Engineering</h2>
      <img src="img/pccoe-logo-.jpeg" alt="PCCOE Logo" class="logo" />
      <h2 class="title">Student Sign-<span class="highlight">In</span></h2>

      <?php if (isset($error)): ?>
        <div class="error-message">
          <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
        </div>
      <?php endif; ?>

      <form action="login.php" method="POST">
        <div class="input-group">
          <label for="username"><i class="fas fa-user"></i> Username</label>
          <input type="text" id="username" name="username" placeholder="Enter your username" required>
        </div>
        <div class="input-group">
          <label for="password"><i class="fas fa-lock"></i> Password</label>
          <input type="password" id="password" name="password" placeholder="Enter your password" required>
          <i class="fas fa-eye toggle-password" onclick="togglePassword()"></i>
        </div>
        <button type="submit" class="btn">
          <i class="fas fa-sign-in-alt"></i> SIGN IN
        </button>
        <div class="help-links">
          <a href="#"><i class="fas fa-question-circle"></i> Need Help?</a>
          <a href="#" class="forgot-password"><i class="fas fa-key"></i> Forgot Password?</a>
        </div>
        <div class="app-links">
          <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Google Play" /></a>
          <a href="#"><img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg" alt="App Store" /></a>
        </div>
      </form>
    </div>
  </div>

  <footer>
    <p>Powered By <span class="eduplus">EduPlus</span> | <span id="live-time"></span></p>
    <div class="social-icons">
      <a href="#" class="social-icon youtube"><i class="fab fa-youtube"></i></a>
      <a href="#" class="social-icon facebook"><i class="fab fa-facebook-f"></i></a>
      <a href="#" class="social-icon instagram"><i class="fab fa-instagram"></i></a>
      <a href="#" class="social-icon twitter"><i class="fab fa-twitter"></i></a>
    </div>
  </footer>

  <script>
    // Toggle password visibility
    function togglePassword() {
      const passwordField = document.getElementById('password');
      const icon = document.querySelector('.toggle-password');
      
      if (passwordField.type === 'password') {
        passwordField.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        passwordField.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    }
    
    // Update live time
    function updateTime() {
      const now = new Date();
      const timeString = now.toLocaleTimeString('en-US', { hour: '2-digit', minute:'2-digit' });
      const dateString = now.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
      document.getElementById('live-time').textContent = `${dateString} • ${timeString}`;
    }
    
    setInterval(updateTime, 1000);
    updateTime();
    
    // Add input focus effects
    document.querySelectorAll('input').forEach(input => {
      input.addEventListener('focus', function() {
        this.parentElement.querySelector('label').style.color = 'var(--primary)';
      });
      
      input.addEventListener('blur', function() {
        this.parentElement.querySelector('label').style.color = 'var(--dark)';
      });
    });
    
    // Add animation to form elements on load
    document.addEventListener('DOMContentLoaded', function() {
      const inputs = document.querySelectorAll('.input-group');
      inputs.forEach((input, index) => {
        input.style.animation = `fadeInUp 0.6s ease-out ${index * 0.1 + 0.4}s both`;
      });
    });
  </script>
</body>
</html>