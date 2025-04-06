<?php
$host = "localhost";
$dbname = "student_portal";
$user = "root";
$pass = ""; // your MySQL password, often empty on localhost

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
