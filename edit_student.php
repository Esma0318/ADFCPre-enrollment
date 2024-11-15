<?php
include 'db_connection.php';

if (isset($_GET['id'])) {
    $student_id = $_GET['id'];
    $student = $conn->query("SELECT * FROM students WHERE id = $student_id")->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $status = $_POST['status'];

        $sql = "UPDATE students SET student_name = '$name', student_email = '$email', status = '$status' WHERE id = $student_id";
        $conn->query($sql);

        header('Location: admin_dashboard.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: auto;
        }
        input[type="text"],
        input[type="email"],
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #5cb85c;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #4cae4c;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.querySelector('form');

            form.addEventListener('submit', function (event) {
                const name = document.querySelector('input[name="name"]').value;
                const email = document.querySelector('input[name="email"]').value;

                if (name.trim() === '' || email.trim() === '') {
                    alert('Please fill in all fields.');
                    event.preventDefault();
                }
            });
        });
    </script>
</head>
<body>
    <form method="POST">
        <h2>Edit Student</h2>
        Name: <input type="text" name="name" value="<?= htmlspecialchars($student['student_name']) ?>" required>
        Email: <input type="email" name="email" value="<?= htmlspecialchars($student['student_email']) ?>" required>
        Status: <select name="status">
            <option value="pending" <?= $student['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
            <option value="approved" <?= $student['status'] == 'approved' ? 'selected' : '' ?>>Approved</option>
        </select>
        <button type="submit">Save</button>
    </form>
</body>
</html>
