<?php
include("db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $faculty_id = $_POST['faculty_id'];

    $stmt = $conn->prepare("DELETE FROM faculty WHERE faculty_id = ?");
    $stmt->bind_param("s", $faculty_id);

    if ($stmt->execute()) {
        echo "<script>alert('Faculty deleted successfully!'); window.location.href = 'delete_faculty.php';</script>";
        exit;
    } else {
        echo "<script>alert('Error deleting faculty: " . $stmt->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Delete Faculty</title>
  <link rel="stylesheet" href="delete_faculty.css" />
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f0f4f8;
      margin: 0;
      padding: 0;
    }

    .delete-container {
      width: 400px;
      margin: 100px auto;
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }

    h1 {
      text-align: center;
      margin-bottom: 25px;
      color: #333;
    }

    form input {
      width: 100%;
      padding: 12px;
      margin: 12px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 14px;
    }

    button {
      width: 100%;
      padding: 12px;
      background-color: #dc3545;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
    }

    button:hover {
      background-color: #b52a38;
    }
  </style>
</head>
<body>
  <div class="delete-container">
    <h1>Delete Faculty</h1>
    <form method="POST">
      <input type="text" name="faculty_id" placeholder="Enter Faculty ID to Delete" required />
      <button type="submit">Delete</button>
    </form>
  </div>
</body>
</html>
