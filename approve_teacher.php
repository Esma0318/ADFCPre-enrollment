<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin') {
    header('Location: login.php');
    exit;
}

if (isset($_GET['id'])) {
    $teacher_id = $_GET['id'];
    
    // Update the teacher's status
    $stmt = $conn->prepare("UPDATE users SET status = 'approved' WHERE id = ?");
    $stmt->bind_param("i", $teacher_id);
    
    if ($stmt->execute()) {
        echo "Teacher approved successfully.";
    } else {
        echo "Error approving teacher: " . $stmt->error;
    }
    
    $stmt->close();
}

$conn->close();
header("Location: admin_dashboard.php");
exit;
?>
