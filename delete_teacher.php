<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $teacher_id = $_GET['id'];
    // Delete the teacher from the database
    $sql = "DELETE FROM users WHERE id = $teacher_id AND user_type = 'teacher'";
    $conn->query($sql);

    header('Location: admin_dashboard.php');
}
?>
