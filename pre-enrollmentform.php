<?php
session_start(); // Start the session

include 'db_connection.php';
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_name = $_POST['first_name'] . ' ' . $_POST['last_name'];
    $student_email = $_POST['email'];
    $student_id = isset($_POST['student_id']) ? trim($_POST['student_id']) : null;

    // Check if the student is old or new
    if ($_POST['old_or_new'] === 'new') {
        // Generate the custom ID for new students
        $currentYear = date("y");
        $result = $conn->query("SELECT student_id FROM students WHERE student_id LIKE '$currentYear-%' ORDER BY student_id DESC LIMIT 1");

        if ($result->num_rows > 0) {
            $latestId = $result->fetch_assoc()['student_id'];
            $number = intval(substr($latestId, 3)) + 1;
        } else {
            $number = 1;
        }

        $newId = $currentYear . '-' . str_pad($number, 5, '0', STR_PAD_LEFT);
    } else {
        // Validate student ID for old students
        if (empty($student_id)) {
            $_SESSION['error_message'] = "Please enter your Student ID.";
            header('Location: index.php'); // Redirect back to the form
            exit;
        }
        $newId = $student_id; // Use the provided student ID for old students
    }

    // Prepare pre-enrollment data as a JSON string
    $pre_enrollment_data = json_encode([
        'old_or_new' => $_POST['old_or_new'],
        // Include other necessary pre-enrollment fields here
    ]);

    // Insert into the database
    $stmt = $conn->prepare("INSERT INTO students (student_id, student_name, student_email, pre_enrollment_data, status) VALUES (?, ?, ?, ?, 'pending')");
    $stmt->bind_param("ssss", $newId, $student_name, $student_email, $pre_enrollment_data);
    $stmt->execute();
    $stmt->close();

    // Set a success message
    $_SESSION['success_message'] = "Thank you for your submission. We will email when the pre-enrollment is approved!";

    // Sending email notification using PHPMailer
    // Sending email notification using PHPMailer
$mail = new PHPMailer(true); // Create a new PHPMailer instance

try {
    //Server settings
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                   // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                 // Enable SMTP authentication
    $mail->Username   = 'nashethan070318@gmail.com';             // SMTP username
    $mail->Password   = 'your-email-password';                // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      // Enable TLS encryption
    $mail->Port       = 587;                                  // TCP port to connect to

    // Enable verbose debug output
    $mail->SMTPDebug = 2; 

    //Recipients
    $mail->setFrom('your-email@example.com', 'Your Name');    // Set the sender
    $mail->addAddress($student_email, $student_name);         // Add a recipient

    // Content
    $mail->isHTML(true);                                      // Set email format to HTML
    $mail->Subject = 'Pre-enrollment Confirmation';
    $mail->Body    = "Dear $student_name,<br><br>Your pre-enrollment application has been submitted successfully. We will notify you via email once it has been processed.<br><br>Thank you!";

    $mail->send();                                           // Send the email
} catch (Exception $e) {
    // Handle the error if the email could not be sent
    $_SESSION['error_message'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    header('Location: index.php'); // Redirect back to the form
    exit;
}
    // Redirect to index.php
    header('Location: index.php');
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pre-enrollment Form</title>
    <link rel="stylesheet" href="css/preform.css">
    <script>
        function toggleOtherInput() {
            const select = document.getElementById('course');
            const otherInput = document.getElementById('other_course');
            otherInput.style.display = select.value === 'Other' ? 'block' : 'none';
        }

        function toggleStudentIdInput() {
            const oldOrNewSelect = document.querySelector('select[name="old_or_new"]');
            const studentIdInput = document.getElementById('student_id');
            const studentIdLabel = document.getElementById('student_id_label');

            // Show or hide student ID input based on the selection
            if (oldOrNewSelect.value === 'old') {
                studentIdInput.style.display = 'block';
                studentIdLabel.style.display = 'block';
            } else {
                studentIdInput.style.display = 'none';
                studentIdLabel.style.display = 'none';
                studentIdInput.value = ''; // Clear the input if switching to new student
            }
        }

        function capitalizeFirstLetter(input) {
            const words = input.value.split(' ').map(word => {
                if (word.length > 0) {
                    return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
                }
                return '';
            });
            input.value = words.join(' ');
        }

        // Event listener to toggle student ID input when the old/new selection changes
        document.addEventListener('DOMContentLoaded', function() {
            const oldOrNewSelect = document.querySelector('select[name="old_or_new"]');
            oldOrNewSelect.addEventListener('change', toggleStudentIdInput);
        });
    </script>
</head>
<body>

<div class="form-container">
    <h2>Pre-enrollment Form</h2>
    <form method="POST" action="">
        <label for="old_or_new">Are you a new or old student?</label>
        <select name="old_or_new" required>
            <option value="" disabled selected></option>
            <option value="new">New Student</option>
            <option value="old">Old Student</option>
        </select>

        <!-- Student ID Input -->
        <label for="student_id" id="student_id_label" style="display: none;">Student ID</label>
        <input type="text" id="student_id" name="student_id" style="display: none;" placeholder="Enter Student ID">

        <label for="first_name">First Name</label>
        <input type="text" name="first_name" required oninput="capitalizeFirstLetter(this)">

        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" required oninput="capitalizeFirstLetter(this)">

        <label for="mi">Middle Initial</label>
        <input type="text" name="mi" oninput="capitalizeFirstLetter(this)">

        <label for="age">Age</label>
        <input type="number" name="age" required>

        <label for="gender">Gender</label>
        <select name="gender" required>
            <option value="" disabled selected></option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>

        <label for="province">Province</label>
        <input type="text" name="province" required oninput="capitalizeFirstLetter(this)">

        <label for="city">City</label>
        <input type="text" name="city" required oninput="capitalizeFirstLetter(this)">

        <label for="street">Street Address</label>
        <input type="text" name="street" required oninput="capitalizeFirstLetter(this)">

        <label for="zipcode">Zipcode</label>
        <input type="text" name="zipcode" required>

        <label for="birthday">Birthday</label>
        <input type="date" name="birthday" required>

        <label for="religion">Religion</label>
<input type="text" name="religion" required oninput="capitalizeFirstLetter(this)">

<label for="email">Email</label>
<input type="email" name="email" required pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" title="Please enter a valid email address.">

<label for="contact_number">Contact Number</label>
    <input type="tel" name="contact_number">


        <label for="guardian">Guardian Name</label>
        <input type="text" name="guardian" required oninput="capitalizeFirstLetter(this)">

        <label for="guardian_relation">Relation to Guardian</label>
        <select name="guardian_relation" required>
            <option value="" disabled selected></option>
            <option value="Father">Father</option>
            <option value="Mother">Mother</option>
            <option value="Sibling">Sibling</option>
            <option value="Grandmother">Grandmother</option>
            <option value="Grandfather">Grandfather</option>
            <option value="Other">Other</option>
        </select>

        <label for="last_school">Last School Attended</label>
        <input type="text" name="last_school" required oninput="capitalizeFirstLetter(this)">

        <label for="course">Preferred Course</label>
        <select name="preferred_course" id="course" onchange="toggleOtherInput()">
            <option value="" disabled selected></option>
            <option value="BS_IT">BS IT</option>
            <option value="BS_Nursing">BS Nursing</option>
            <option value="BS_Criminology">BS Criminology</option>
            <option value="BS_Engineering">BS Engineering</option>
            <option value="BSED">BSED</option>
            <option value="BEED">BEED</option>
            <option value="BS_HM">BS HM</option>
            <option value="BS_Tourism">BS Tourism</option>
            <option value="BS_Entrep">BS Entrep</option>
            <option value="Other">Other (please specify)</option>
        </select>
        <input type="text" id="other_course" name="other_course" style="display:none;" placeholder="Please specify your course">

        <button type="submit">Submit</button>
    </form>
</div>

</body>
</html>
