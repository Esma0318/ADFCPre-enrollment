<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="CSS/dash.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>
        function showSection(section) {
            // Hide all sections
            document.querySelectorAll('.section').forEach(s => s.classList.add('hidden'));
            // Show the selected section
            document.getElementById(section).classList.remove('hidden');
        }

        function searchStudents() {
    const input = document.getElementById('search').value.toLowerCase();
    const rows = document.querySelectorAll('#studentsTable tr'); // Select all rows in the table

    rows.forEach((row, index) => {
        if (index === 0) return; // Skip the header row
        const studentId = row.cells[1].textContent.toLowerCase(); // Get the student ID from the second cell (index 1)
        
        if (studentId.includes(input)) {
            row.style.display = ''; // Show row
        } else {
            row.style.display = 'none'; // Hide row
        }
    });
}


    </script>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <h2>Admin Profile</h2>
    <ul>
        <li><a href="#" onclick="showSection('manageStudentsSection')"><i class="fas fa-users"></i> Manage Students</a></li>
        <li><a href="#" onclick="showSection('manageTeachersSection')"><i class="fas fa-chalkboard-teacher"></i> Manage Teachers</a></li>
        <li><a href="#" onclick="showSection('manageTeacherAccountsSection')"><i class="fas fa-user-cog"></i>Teacher Accounts</a></li>
        <li><a href="#" onclick="showSection('preEnrollmentSection')"><i class="fas fa-file-alt"></i> Pre-Enrollment Data</a></li>
        <li><a href="#" onclick="showSection('gradesSection')"><i class="fas fa-graduation-cap"></i> Student Reports</a></li>
    </ul>
    <button class="logout-btn" onclick="window.location.href='logout.php'"><i class="fas fa-sign-out-alt"></i> Logout</button>
</div>


<!-- Main Content -->
<div class="content">
<?php
session_start();
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin') {
    header('Location: login.php');
    exit;
}

// Include the database connection
include 'db_connection.php'; // Ensure this file is correctly included

// Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all grades
$grades = $conn->query("SELECT g.id, s.student_name, g.remarks FROM grades g JOIN students s ON g.student_id = s.id");
if (!$grades) {
    die("Error in grades query: " . $conn->error);
}

// Fetch data for managing teachers and students
$students = $conn->query("SELECT * FROM students");
if (!$students) {
    die("Error in students query: " . $conn->error);
}

$teachers = $conn->query("SELECT * FROM users WHERE user_type = 'teacher'");
if (!$teachers) {
    die("Error in teachers query: " . $conn->error);
}

$preEnrollmentStudents = $conn->query("SELECT * FROM students WHERE status = 'pending'");
if (!$preEnrollmentStudents) {
    die("Error in preEnrollmentStudents query: " . $conn->error);
}

// Add student
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_student'])) {
    $student_name = $_POST['student_name'];
    $student_email = $_POST['student_email'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("INSERT INTO students (student_name, student_email, status) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $student_name, $student_email, $status);
    $stmt->execute();
    $stmt->close();
    header("Location: admin_dashboard.php"); // Redirect to the dashboard after adding
    exit;
}


// Add teacher
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_teacher'])) {
    $teacher_name = $_POST['teacher_name'];
    $teacher_email = $_POST['teacher_email'];
    $teacher_password = password_hash($_POST['teacher_password'], PASSWORD_DEFAULT);
    $user_type = 'teacher';

    $stmt = $conn->prepare("INSERT INTO users (username, email, password, user_type) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $teacher_name, $teacher_email, $teacher_password, $user_type);

    if ($stmt->execute()) {
        echo "New teacher added successfully.";
    } else {
        echo "Error adding teacher: " . $stmt->error;
    }
    $stmt->close();
    header("Location: admin_dashboard.php"); // Redirect to refresh the page
    exit;
}



?>

<h1>Admin Dashboard</h1>

<!-- Search Bar -->
<div class="search-container">
    <input type="text" id="search" placeholder="Search for students..." onkeyup="searchStudents()">
</div>

<!-- Manage Students Section -->
<div id="manageStudentsSection" class="section hidden">
    <h2>Manage Students</h2>
    
    <!-- Add Student Form -->
    <div class="form-container">
        <h3>Add New Student</h3>
        <form method="POST" action="">
            <input type="text" name="student_name" placeholder="Student Name" required>
            <input type="email" name="student_email" placeholder="Student Email" required>
            <input type="text" name="status" placeholder="Status" required>
            <button type="submit" name="add_student">Add Student</button>
        </form>
    </div>

    <!-- Students Table -->
    <table id="studentsTable">
        <tr>
            <th>Student id</th>
            <th>Student Type</th>
            <th>Name</th>
            <th>Email</th>
            <th>Age</th>
            <th>Gender</th>
            <th>Address</th>
            <th>Birthday</th>
            <th>Religion</th>
            <th>Contact Number</th>
            <th>Guardian</th>
            <th>Last School Attended</th>
            <th>Preferred Course</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php 
        // Query to fetch only approved students
        $students = $conn->query("SELECT * FROM students WHERE status = 'approved'");
        
        while($student = $students->fetch_assoc()): ?>
            <?php $preEnrollmentData = json_decode($student['pre_enrollment_data'], true); ?>
            <tr>
                <td><?= htmlspecialchars($student['student_id']) ?></td>
                <td><?= htmlspecialchars($preEnrollmentData['old_or_new'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($student['student_name']) ?></td>
                <td><?= htmlspecialchars($student['student_email']) ?></td>
                <td><?= htmlspecialchars($preEnrollmentData['age'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($preEnrollmentData['gender'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($preEnrollmentData['address']['street'] ?? 'N/A') . ', ' . 
                        htmlspecialchars($preEnrollmentData['address']['city'] ?? 'N/A') . ', ' . 
                        htmlspecialchars($preEnrollmentData['address']['province'] ?? 'N/A') . ' ' . 
                        htmlspecialchars($preEnrollmentData['address']['zipcode'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($preEnrollmentData['birthday'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($preEnrollmentData['religion'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($preEnrollmentData['contact_number'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($preEnrollmentData['guardian'] ?? 'N/A') . ' (' . 
                        htmlspecialchars($preEnrollmentData['guardian_relation'] ?? 'N/A') . ')' ?></td>
                <td><?= htmlspecialchars($preEnrollmentData['last_school'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($preEnrollmentData['course'] ?? 'N/A') ?></td>
                <td><?= htmlspecialchars($student['status']) ?></td>
                <td>
                    <a href="edit_student.php?id=<?= $student['id'] ?>">Edit</a> |
                    <a href="delete_student.php?id=<?= $student['id'] ?>" onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>


<!-- Manage Teachers Section -->
<div id="manageTeachersSection" class="section hidden">
    <h2>Manage Teachers</h2>

    <!-- Add Teacher Account Form -->
    <div class="form-container">
    <h3>Add New Teacher Account</h3>
    <form method="POST" action="">
        <input type="text" name="teacher_name" placeholder="Teacher Name" required>
        <input type="email" name="teacher_email" placeholder="Teacher Email" required>
        <input type="password" name="teacher_password" placeholder="Password" required>
        <button type="submit" name="add_teacher">Add Teacher</button>
    </form>
</div>


    <!-- Teachers Table -->
    <table id="teachersTable">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <?php while($teacher = $teachers->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($teacher['id']) ?></td>
                <td><?= htmlspecialchars($teacher['username']) ?></td>
                <td><?= htmlspecialchars($teacher['email']) ?></td>
                <td>
                    <a href="edit_teacher.php?id=<?= $teacher['id'] ?>">Edit</a> |
                    <a href="delete_teacher.php?id=<?= $teacher['id'] ?>" onclick="return confirm('Are you sure you want to delete this teacher?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

<!-- Teacher Accounts Section -->
<div id="manageTeacherAccountsSection" class="section hidden">
    <h2>Manage Teacher Accounts</h2>

    <!-- Teacher Accounts Table -->
    <table id="teacherAccountsTable">
        <tr>
            <th>Teacher ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <?php while($teacherAccount = $teachers->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($teacherAccount['id']) ?></td>
                <td><?= htmlspecialchars($teacherAccount['username']) ?></td>
                <td><?= htmlspecialchars($teacherAccount['email']) ?></td>
                <td><?= htmlspecialchars($teacherAccount['user_type']) ?></td>
                <td>
                    <a href="edit_teacher_account.php?id=<?= $teacherAccount['id'] ?>">Edit</a> |
                    <a href="delete_teacher_account.php?id=<?= $teacherAccount['id'] ?>" onclick="return confirm('Are you sure you want to delete this teacher account?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>


<!-- Pre-Enrollment Data Section -->
<div id="preEnrollmentSection" class="section hidden">
    <h2>Pre-Enrollments</h2>
    <table id="preEnrollmentTable">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php while ($preStudent = $preEnrollmentStudents->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($preStudent['id']) ?></td>
                <td><?= htmlspecialchars($preStudent['student_name']) ?></td>
                <td><?= htmlspecialchars($preStudent['student_email']) ?></td>
                <td><?= htmlspecialchars($preStudent['status']) ?></td>
                <td>
                    <a href="edit_student.php?id=<?= $preStudent['id'] ?>">Edit</a> |
                    <a href="delete_student.php?id=<?= $preStudent['id'] ?>" onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

<!-- Grades Section -->
<div id="gradesSection" class="section hidden">
    <h2>View Grades</h2>
    <table id="gradesTable">
        <tr>
            <th>ID</th>
            <th>Student Name</th>
            <th>Remarks</th>
        </tr>
        <?php while($grade = $grades->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($grade['id']) ?></td>
                <td><?= htmlspecialchars($grade['student_name']) ?></td>
                <td><?= htmlspecialchars($grade['remarks']) ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>

</div>
</body>
</html>