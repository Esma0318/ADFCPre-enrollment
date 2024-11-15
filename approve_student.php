<?php
session_start();
include 'db_connection.php'; // Ensure this file is correctly included

if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin') {
    header('Location: login.php');
    exit;
}

if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // Update the student's status to approved
    $stmt = $conn->prepare("UPDATE students SET status = 'approved' WHERE id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $stmt->close();

    // Fetch student's email for notification
    $stmt = $conn->prepare("SELECT student_email, student_name FROM students WHERE id = ?");
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $stmt->bind_result($student_email, $student_name);
    $stmt->fetch();
    $stmt->close();

    // Send notification email
    $subject = "Your Enrollment Status has been Updated";
    $message = "Hello " . htmlspecialchars($student_name) . ",\n\nYour enrollment status has been approved. Welcome to the program!\n\nBest regards,\nAdmin";
    $headers = "From: admin@example.com"; // Change to your admin email

    mail($student_email, $subject, $message, $headers);

    header("Location: admin_dashboard.php"); // Redirect back to the dashboard
    exit;
}
?>
