<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include DB connection
include("db_config.php");

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $course_id = trim($_POST['course_id']);

    if (!empty($course_id)) {
        // Check if course exists
        $checkStmt = $conn->prepare("SELECT 1 FROM courses WHERE course_id = ?");
        $checkStmt->bind_param("s", $course_id);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            // Delete the course
            $stmt = $conn->prepare("DELETE FROM courses WHERE course_id = ?");
            $stmt->bind_param("s", $course_id);

            if ($stmt->execute()) {
                echo "<script>alert('Course deleted successfully!');</script>";
            } else {
                echo "<script>alert('Error deleting course.');</script>";
            }

            $stmt->close();
        } else {
            echo "<script>alert('Course ID not found!');</script>";
        }

        $checkStmt->close();
    } else {
        echo "<script>alert('Please enter a Course ID.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Delete Course</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" />
  <style>
    body {
      background: #fdfcfc;
      font-family: 'Poppins', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .form-container {
      background: #fff;
      padding: 30px 40px;
      border-radius: 15px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
      width: 350px;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #bb2124;
    }

    input {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 8px;
    }

    button {
      width: 100%;
      padding: 10px;
      background: #dc3545;
      color: #fff;
      border: none;
      border-radius: 8px;
      font-weight: bold;
      cursor: pointer;
    }

    button:hover {
      background: #bd2130;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Delete Course</h2>
    <form method="POST" action="">
      <input type="text" name="course_id" placeholder="Enter Course ID" required>
      <button type="submit">Delete Course</button>
    </form>
  </div>
</body>
</html>
