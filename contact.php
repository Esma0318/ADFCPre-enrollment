<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADFC-ContactUs</title>
    <style>
        /* Reset some default styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f8fafc;
            color: #333;
        }

        /* Main wrapper */
        #mainwrapper {
            max-width: 1000px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Header */
        #header {
            text-align: center;
            margin-bottom: 20px;
        }

        #header img {
            max-width: 100%;
            height: auto;
        }

        /* Menu styles */
        #menu {
            background: #5639d4;
            padding: 10px 0;
        }

        #menu ul {
            list-style: none;
            display: flex;
            justify-content: center;
        }

        #menu li {
            margin: 0 15px;
        }

        #menu a {
            color: white;
            text-decoration: none;
            padding: 10px 15px;
            transition: background 0.3s, color 0.3s;
        }
        #menu a:hover {
            background: #005f9e;
            color: #fff;
            
        }

        /* Main content */
        #main {
            padding: 20px;
            text-align: justify;
        }

        /* Footer styles */
        #footer {
            text-align: center;
            padding: 20px 0;
            border-top: 1px solid #ccc;
            margin-top: 20px;
            color: #666;
        }

        .clearfix {
            clear: both;
        }
    </style>
</head>
<body>
    <div id="mainwrapper">
        <div id="header">
            <img src="images/1.png" alt="Logo">
        </div>
        <div id="menu">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="contact.php" class="3">Contact Us</a></li>
                <div class="clearfix"></div>
            </ul>
        </div>
        <div id="main" style="padding:20px; text-align:justify; font-family:arial;">
		Address: &nbsp;&nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&ensp;P. Burgos Street
		<br>
		<br>
Tacloban City, &nbsp;&nbsp; 6500 Philippines
<br>
<br>
Telephone: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&ensp;  +63 909 344 3725
<br>
<br>
Website:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&ensp;  &nbsp;&nbsp;&nbsp;&nbsp;<a href="adfc.edu.4t.com">adfc.edu.4t.com</a>
        </div>
        <div id="footer">
            &copy; 2024 Asian Development Foundation College. All rights reserved.
        </div>
        <div class="clearfix"></div>
    </div>
</body>
</html>
