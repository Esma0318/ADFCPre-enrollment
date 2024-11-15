<?php
session_start();
include 'db_connection.php';  // Includes the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];  // Plain-text password entered by user

    // Fetch user from the database
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Check if user exists
    if ($user) {
        // Debugging: Check if we are getting the correct user data from the database
        var_dump($user);  // Print out the whole user record for debugging
    } else {
        echo "No user found in the database.";  // If no user is found for the given username
    }

    // Directly compare the input password with the plain-text password in the database
    if ($password === $user['password']) {
        // If the passwords match, start the session
        $_SESSION['user_type'] = $user['user_type'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_id'] = $user['id'];

        // Debugging: Check session variables before redirection
        echo 'Session Data: ';
        var_dump($_SESSION);  // Check if session variables are set correctly

        // Redirect based on user type
        if ($user['user_type'] == 'admin') {
            header('Location: admin_dashboard.php');
            exit;  // Make sure no further code runs after the redirect
        } elseif ($user['user_type'] == 'teacher') {
            header('Location: teacher_dashboard.php');
            exit;
        }
    } else {
        // If passwords do not match
        echo "Invalid credentials.";
    }
}
?>
