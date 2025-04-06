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
    if (empty($contact)) $errors[] = "Faculty Contact is required";

    // If no errors, insert data
    if (empty($errors)) {
        try {
            // MySQLi version (if your db_config.php uses MySQLi)
            $stmt = $conn->prepare("INSERT INTO faculty (faculty_id, name, email, contact) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $faculty_id, $name, $email, $contact);
            $stmt->execute();
            
            // OR PDO version (if your db_config.php uses PDO)
            // $stmt = $conn->prepare("INSERT INTO faculty (faculty_id, name, email, contact) VALUES (:faculty_id, :name, :email, :contact)");
            // $stmt->bindParam(':faculty_id', $faculty_id);
            // $stmt->bindParam(':name', $name);
            // $stmt->bindParam(':email', $email);
            // $stmt->bindParam(':contact', $contact);
            // $stmt->execute();

            $success = "Faculty added successfully!";
        } catch (Exception $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Add Faculty</title>
  <link rel="stylesheet" href="add_faculty.css">
  <style>
    .form-container {
      max-width: 500px;
      margin: 50px auto;
      padding: 20px;
      border: 1px solid #ddd;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .error {
      color: red;
      margin-bottom: 15px;
    }
    .success {
      color: green;
      margin-bottom: 15px;
    }
    input {
      width: 100%;
      padding: 10px;
      margin: 8px 0;
      box-sizing: border-box;
    }
    button {
      background-color: #4CAF50;
      color: white;
      padding: 10px 15px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      width: 100%;
    }
    button:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h1>Add Faculty</h1>

    <?php if (!empty($errors)): ?>
      <div class="error">
        <?php foreach ($errors as $error): ?>
          <p><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
      <div class="success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="POST" action="add_faculty.php">
      <input type="text" name="faculty_id" placeholder="Faculty ID" required>
      <input type="text" name="name" placeholder="Faculty Name" required>
      <input type="email" name="email" placeholder="Faculty Email" required>
      <input type="tel" name="contact" placeholder="Faculty Contact" required>
      <button type="submit">Add Faculty</button>
    </form>
  </div>
</body>
</html>