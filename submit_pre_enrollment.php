<!-- submit_pre_enrollment.php -->
<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Gather form data
    $student_name = $_POST['first_name'] . ' ' . $_POST['last_name'] . ' ' . $_POST['mi'];
    $student_email = $_POST['email'];
    $pre_enrollment_data = json_encode([
        'old_or_new' => $_POST['old_or_new'],
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'mi' => $_POST['mi'],
        'age' => $_POST['age'],
        'gender' => $_POST['gender'],
        'address' => [
            'street' => $_POST['street'],
            'city' => $_POST['city'],
            'province' => $_POST['province'],
            'zipcode' => $_POST['zipcode']
        ],
        'birthday' => $_POST['birthday'],
        'religion' => $_POST['religion'],
        'contact_number' => $_POST['contact_number'],
        'guardian' => $_POST['guardian'],
        'guardian_relation' => $_POST['guardian_relation'],
        'last_school' => $_POST['last_school'],
        'course' => $_POST['course']
    ]);

    // Insert into students table
    $stmt = $conn->prepare("INSERT INTO students (student_name, student_email, pre_enrollment_data, status) VALUES (?, ?, ?, 'pending')");
    $stmt->bind_param("sss", $student_name, $student_email, $pre_enrollment_data);
    $stmt->execute();
    $stmt->close();

    // Redirect to a thank you page or confirmation message
    header('Location: thank_you.php');
    exit;
}
?>
