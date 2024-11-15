<?php
session_start();

// Make sure the user is logged in as a teacher
if ($_SESSION['user_type'] != 'teacher') {
    header('Location: login.php');
    exit;
}

include 'db_connection.php';

// Fetch students for this teacher securely using the logged-in teacher's ID (from session)
$teacher_id = $_SESSION['user_id']; // Teacher ID is stored in session
$stmt = $conn->prepare("SELECT id, student_name, student_id FROM students WHERE teacher_id = ?");
$stmt->bind_param("i", $teacher_id); // Bind teacher_id as integer to the prepared statement
$stmt->execute();
$students = $stmt->get_result();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/teacher.css">
    <title>Submit Grades</title>
</head>
<body>

<header>
    <!-- Profile Button -->
    <div class="profile-btn" onclick="toggleDropdown()">
        <img src="images/logo.png" alt="Profile"> <!-- Replace with your profile icon image -->
    </div>

    <h1>Submit Grades</h1>
</header>

<!-- Dropdown Menu -->
<div id="profileDropdown" class="dropdown">
    <!-- Simple Links/Buttons for Profile Menu -->
    <button class="dropdown-item" onclick="window.location.href='view_profile.php'">View Profile</button>
    <button class="dropdown-item" onclick="window.location.href='change_password.php'">Change Password</button>
    <button class="dropdown-item" onclick="window.location.href='logout.php'">Logout</button>
</div>

<!-- Submit Grade Form -->
<form action="submit_grade.php" method="POST">
    <label for="student_id">Student ID:</label>
    <input type="text" name="student_id" placeholder="Enter Student ID" pattern="[\d-]+" title="Student ID should contain only numbers and dashes" required>

    <label for="remarks">Remarks:</label>
    <select name="remarks" required>
        <option value="">-- Select Remarks --</option>
        <option value="Passed">Passed</option>
        <option value="Failed">Failed</option>
    </select>

    <button type="submit">Submit</button>
</form>

<!-- Students List -->
<h2>Students List</h2>
<table>
    <tr>
        <th>Student ID</th>
        <th>Student Name</th>
    </tr>
    <?php while($student = $students->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($student['student_id']) ?></td>
        <td><?= htmlspecialchars($student['student_name']) ?></td>
    </tr>
    <?php endwhile; ?>
</table>

<!-- Javascript for Dropdown Toggle -->
<script>
    function toggleDropdown() {
        var dropdown = document.getElementById("profileDropdown");
        dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
    }

    // Close dropdown if user clicks outside of it
    window.onclick = function(event) {
        var dropdown = document.getElementById("profileDropdown");
        var profileBtn = document.querySelector(".profile-btn");
        if (!profileBtn.contains(event.target)) {
            dropdown.style.display = "none";
        }
    }
</script>

</body>
</html>
