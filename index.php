<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADFC Online Pre-enrollment System</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&family=Roboto:wght@400&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Acme&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/index.cs">
<style>
    body {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  background: #f8fafc;
  margin: 0;
}
header {
  display: flex;
  align-items: center;
  background-color: #f4f6f8;
  padding: 10px 0;
}
h1 {
  font-family: 'Times New Roman', Times, serif;
  color: #050343;
  margin-left: 20px;
  flex: 1;
}
nav {
  margin-bottom: 0;
  font-weight: bold;
  color: #02031d;
  padding: 0;
}
.navbar-nav .nav-link {
  color: black;
}
.navbar-nav .nav-link:hover {
  color: #0056b3;
}
main {
  flex: 1;
  padding: 10px;
  margin-top: 0;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0);
}
footer {
  margin-top: 20px;
  text-align: center;
  color: #52515f;
  font-size: 0.8em;
}
.highlight-text {
  font-family: 'Acme', sans-serif;
  font-weight: 400;
  font-style: normal;
  font-weight: bold;
  font-size: 3em;
  color: #898696;
  transition: all 0.3s;
  text-align: center;
}
.glass-effect {
  background-image: url('images/7.jpg'); /* Your background image */
  background-size: cover; /* Cover the entire container */
  background-position: center; /* Center the image */
  background-repeat: no-repeat; /* Prevent the image from repeating */
  background-color: rgba(
    255,
    255,
    255,
    0.6
  ); /* Fallback color with some opacity */
  backdrop-filter: blur(10px); /* Add blur effect behind the content */
  border-radius: 5px;
  padding: 40px;
  color: #050346;
  text-align: center;
  box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
  font-size: larger;
  max-width: 100%;
}

.btn {
  transition: all 0.3s;
  padding: 20px 40px;
  font-size: 1.2em;
  font-weight: bold;
  background: linear-gradient(to left, #cfab35, #9b4d04);
  color: white;
  border: none;
  border-radius: 20px;
}
.btn:hover {
  background: linear-gradient(to right, #cfab35, #9b4d04);
  color: white;
  transform: scale(1.05);
  box-shadow: 0 4px 20px rgba(247, 208, 125, 0.5);
}
.logo {
  margin-left: 5px;
  margin-top: 5px;
  width: 120px;
}

</style>
</head>
<body>

<header class="text-center mb-0">
    <img src="images/logo.png" alt="ADFC Logo" style="height: 90px;" class="logo">
    <h1>ADFC Pre-enrollment</h1>
</header>

<nav class="navbar navbar-expand-md navbar-light bg-light mb-0">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
            <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
            <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
        </ul>
    </div>
</nav>

<main class="text-center mb-4">
    <?php
    if (isset($_SESSION['success_message'])) {
        echo '<div class="alert alert-success success-message">' . $_SESSION['success_message'] . '</div>';
        unset($_SESSION['success_message']);
    }
    ?>
    
    <div class="glass-effect">
    <div class="text-center">
        <br>
        <p  style="color: white;">WELCOME back students!</p>
        <br>
        <br>
        <br>
        <br>
        <a href="pre-enrollmentform.php" class="btn btn-primary">Pre-enroll Now</a>
    </div>
    <br>
    <br>  
    <br>
    <br>
    <br>
    <div>
        <p class="highlight-text">Today, I am proud of ADFC. <br>Tomorrow, ADFC will be proud of me.</p>
    </div>
</div>

    
</main>

<footer class="text-center mt-4 bg-light">
    <hr>
    <p>All rights reserved ADFC ©2024</p>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    setTimeout(function() {
        const message = document.querySelector('.success-message');
        if (message) {
            message.style.display = 'none';
        }
    }, 5000);
</script>
</body>
</html>
