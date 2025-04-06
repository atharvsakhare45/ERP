<?php
include("db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_id = $_POST['course_id'];

    // Check if the course exists before attempting to delete
    $checkStmt = $conn->prepare("SELECT * FROM courses WHERE course_id = ?");
    $checkStmt->bind_param("s", $course_id);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        // Course exists, proceed to delete
        $stmt = $conn->prepare("DELETE FROM courses WHERE course_id = ?");
        $stmt->bind_param("s", $course_id);

        if ($stmt->execute()) {
            echo "<script>alert('Course deleted successfully!'); window.location.href = 'delete_course.html';</script>";
        } else {
            echo "<script>alert('Error deleting course: " . $stmt->error . "'); window.history.back();</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Course ID not found!'); window.history.back();</script>";
    }

    $checkStmt->close();
    $conn->close();
}
?>
