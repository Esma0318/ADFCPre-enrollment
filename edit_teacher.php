<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $teacher_id = $_GET['id'];
    $teacher = $conn->query("SELECT * FROM users WHERE id = $teacher_id")->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $email = $_POST['email'];

        $sql = "UPDATE users SET username = '$username', email = '$email' WHERE id = $teacher_id";
        $conn->query($sql);

        header('Location: admin_dashboard.php');
    }
}
?>

<form method="POST">
    Username: <input type="text" name="username" value="<?= $teacher['username'] ?>" required>
    Email: <input type="email" name="email" value="<?= $teacher['email'] ?>" required>
    <button type="submit">Save</button>
</form>
