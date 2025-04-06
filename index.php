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
  <title>Student Sign-In</title>
  <link rel="stylesheet" href="style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
  <style>
    .error-message {
      color: #ff3333;
      margin-bottom: 15px;
      text-align: center;
    }
    .toggle-password {
      cursor: pointer;
      position: absolute;
      right: 10px;
      top: 35px;
    }
    .input-group {
      position: relative;
    }
  </style>
</head>
<body>
  <div class="container">
    <!-- Left Section: Banner -->
    <div class="banner">
      <img src="img/pccoe_img.jpeg" alt="EduPlus Banner" />
    </div>

    <!-- Right Section: Login Form -->
    <div class="login-section">
      <h2 class="title">Pimpri Chinchwad College Of Engineering</h2>
      <img src="img/pccoe-logo-.jpeg" alt="College Logo" class="logo" />
      <h2 class="title">Student Sign-<span class="highlight">In</span></h2>
      
      <?php if (isset($error)): ?>
        <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
      <?php endif; ?>

      <form action="login.php" method="POST">
        <div class="input-group">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" placeholder="Enter Username" required>
        </div>
        <div class="input-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Enter Password" required>
          <span class="toggle-password" onclick="togglePassword()">👁</span>
        </div>
        <button type="submit" class="btn">SIGN IN</button>
        <div class="help-links">
          <a href="#">Help</a>
          <a href="#" class="forgot-password">Forgot Password?</a>
        </div>
        <div class="app-links">
          <a href="#"><img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Google Play" /></a>
          <a href="#"><img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg" alt="App Store" /></a>
        </div>
      </form>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    <p>Powered By <span class="eduplus">EduPlus</span></p>
    <div class="social-icons">
      <img src="img/youtube_logo.jpeg" alt="YouTube" />
      <img src="img/face_book.jpeg" alt="Facebook" />
      <img src="img/insta_img.jpeg" alt="Instagram" />
      <img src="img/twitter_img.png" alt="Twitter" />
    </div>
  </footer>

  <script>
    function togglePassword() {
      const passwordField = document.getElementById('password');
      const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordField.setAttribute('type', type);
    }
  </script>
</body>
</html>