<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $student_id = $_GET['id'];
    // Delete the student from the database
    $sql = "DELETE FROM students WHERE id = $student_id";
    $conn->query($sql);

    header('Location: admin_dashboard.php');
}
?>
