<?php
session_start();
include("db_config.php");

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM students WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        $_SESSION['username'] = $username;
        header("Location: dashboard.html");
        exit();
    } else {
        echo "<script>alert('Invalid credentials'); window.location.href = 'index.html';</script>";
    }
} else {
    echo "<script>alert('User not found'); window.location.href = 'index.html';</script>";
}

?>
