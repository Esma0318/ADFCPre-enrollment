<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
session_start();
if ($_SESSION['user_type'] != 'student') {
    header('Location: login.php');
    exit;
}
?>

<h1>Pre-Enrollment Form</h1>
<form action="submit_enrollment.php" method="POST">
    <textarea name="pre_enrollment_data" required></textarea>
    <button type="submit">Submit Form</button>
</form>

</body>
</html>