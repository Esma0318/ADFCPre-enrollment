<?php
session_start();

// Ensure user is a teacher
if ($_SESSION['user_type'] != 'teacher') {
    header('Location: login.php');
    exit;
}

include 'db_connection.php';

// Handle grade submission if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id_input = $_POST['student_id'];  // Student ID submitted by the teacher
    $remarks = $_POST['remarks'];  // Remarks field

    // Validate the student ID format
    if (!preg_match("/^\d{2}-\d{6}$/", $student_id_input)) {
        echo "Invalid Student ID format. Please enter a valid ID.";
        exit;
    }

    // Get the teacher ID from the session
    $teacher_id = $_SESSION['user_id'];

    // Prepare the SQL statement to check if the student belongs to the teacher
    $stmt = $conn->prepare("SELECT id FROM students WHERE student_id = ? AND teacher_id = ?");
    $stmt->bind_param("si", $student_id_input, $teacher_id); // Bind student_id as string, teacher_id as integer
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a matching student exists
    if ($result->num_rows > 0) {
        // Insert the grade into the database
        $stmt = $conn->prepare("INSERT INTO grades (student_id, teacher_id, remarks) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $student_id_input, $teacher_id, $remarks);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Successfully inserted grade, redirect to dashboard
            header("Location: teacher_dashboard.php"); // Redirect back to dashboard
            exit;
        } else {
            echo "There was an error inserting the grade.";
        }
    } else {
        echo "Invalid Student ID for your class. Please check the student ID.";
    }

    $stmt->close();
}
?>
