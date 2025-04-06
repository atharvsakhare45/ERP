<?php
include("db_config.php");

$username = $_POST['username'];
$password = $_POST['password'];

// Optional: hash password for security
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Check if user already exists
$check = "SELECT * FROM students WHERE username = '$username'";
$result = $conn->query($check);

if ($result->num_rows > 0) {
    echo "<script>alert('Username already exists!'); window.location.href = 'signup.html';</script>";
} else {
    $sql = "INSERT INTO students (username, password) VALUES ('$username', '$hashed_password')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Sign up successful! Please log in.'); window.location.href = 'index.html';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
