<?php
session_start();

date_default_timezone_set('Asia/Manila');

$host = "fdb1032.awardspace.net";
$username = "4361256_finals";
$password = "JudahPau0112";
$dbname = "4361256_finals";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle search
$search_result = false;
if (isset($_GET['search'])) {
    $search_term = $_GET['search'];
    $search_sql = "SELECT `username`, `name`, `status`, `datetime` FROM user_status WHERE `name` LIKE '$search_term%' ORDER BY `datetime` DESC";
    $search_result = $conn->query($search_sql);
}

// Retrieve all statuses for all users excluding the currently logged-in user
$sql = "SELECT `username`, `name`, `status`, `datetime` FROM user_status WHERE `username` != '" . $_COOKIE['username'] . "' ORDER BY `datetime` DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&family=Silkscreen&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #282c35;
            color: #fff;
        }

        .welcome-box {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 20px;
            padding-bottom: 15px;
            border-radius: 10px;
            width: 80%;
            max-width: 600px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
            text-align: center;
            margin-bottom: 20px;
            margin-top: 40px;
        }

        h3 {
            margin-bottom: 10px;
            font-size: 35px;
            font-family: 'Silkscreen', sans-serif;
            letter-spacing: 2px;
            text-shadow: 0 0 20px #282c35;
            animation: glitch 1s infinite;
        }

        @keyframes glitch {
            0% {
                color: #fff;
            }
            25% {
                color: #00ff00;
            }
            50% {
                color: #ff00ff;
            }
            75% {
                color: #0000ff;
            }
            100% {
                color: #fff; 
            }
        }


        p {
            margin-bottom: 5px;
            font-size: 20px;
        }

        a {
            color: #4CAF50;
            text-decoration: none;
            margin-right: 10px;
            font-size: 10px;
        }

        .dashboard {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            max-width: 900px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
            text-align: center;
            margin-bottom: 20px;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around; 
        }

        li {
            background-color: rgba(255, 255, 255, 0.1);
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            font-size: 16px;
            text-align: left;
            width: 45%; /* Adjust the width as needed */
            transition: background-color 0.3s; /* Add transition for smooth effect */
            transition: 0.3s ease-in-out;
        }

        li:hover {
            background-color: rgba(255, 255, 255, 0.3); /* Change the background color on hover */
            transform: scale(1.05);
            box-shadow: 0 0 30px #282c35;
        }


        .dashboard-actions a {
            font-size: 10px;
            display: inline-block; /* or display: block; */
            transition: transform 0.3s;
            margin-top: 50px;
        }

        .dashboard-actions a:hover {
            transform: scale(1.2);
        }

        .search {
            padding: 10px 15px;
            border-radius: 20px; 
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
            border: none;
            margin-top: 20px;
            margin-left: 15px;
            width: 60%;
            font-family: montserrat;
        }

        .sbutton {
            background-color: #282c35; 
            color: #fff; 
            padding: 10px 15px; 
            cursor: pointer; 
            border: none; 
            border-radius: 5px;
            width: 15%;
            border-top-right-radius: 20px;
            border-bottom-right-radius: 20px;
            font-family: montserrat;
            font-size: auto;
            font-weight: bold;
            letter-spacing: 2px;
            transition: 0.3s ease-in-out;
        }

        .sbutton:hover {
            background-color: black;
            color: lightgray;
            box-shadow: 0 0 15px #282c35;
        }

        
    </style>
    </style>
</head>

<body>
    <div class="welcome-box">
        <h3>Welcome <?php echo $_COOKIE['name']; ?>!</h3>
        <p style="letter-spacing: 1px;";><b>My status:</b></p> <?php echo $_COOKIE['status']; ?>

        <div class="dashboard-actions">
            <a href="status.html" style="color: #C1F2B0; ">EDIT STATUS</a>
            <a href="update.html" style="color: #8ACDD7; ">UPDATE ACCOUNT</a>
            <a href="logout.html" style="color: #DC8686; ">LOGOUT</a>
            <a href="delete.html" style="color: #F05941; ">DELETE</a>
        </div>
    </div>

    <div class="dashboard">
        <!-- Search form -->
        
        <form action="" method="GET" style="margin-bottom: 20px;">
            <label for="search" style="font-size: 18px; color: #fff;">Search by Name :</label>
            <input type="text" class="search" name="search" placeholder="Enter name" required>
            <input type="submit" value="Search" class="sbutton">
        </form>

        <!-- Display search results -->
        <?php
        if ($search_result !== false && $search_result->num_rows > 0) {
            echo "<ul>";
            while ($row = $search_result->fetch_assoc()) {
                echo "<li><img src='user.png' alt='Pin Icon' style='width: 50px; height: 50px; margin-bottom: -20px;'> 
                        <strong style='letter-spacing: 1px; color: #FFB534; font-size: 20px; margin-left: 5px;'>" . $row['name'] . "</strong>
                        <div style='color: #B6BBC4; font-size: 12px; margin-left: 57px;'>Updated on " . date('F j, Y, g:i a', strtotime($row['datetime'])) . "</div>
                        <hr style='border: 1px solid gray; margin-top: 15px;'>
                        <p style='font-size: 16px; margin-top: 20px;'>Status : " . $row['status'] . "<p></li>";
            }
            echo "</ul>";
        } else {
            echo "<br>No matching names found.";
        }
        ?>
    </div>

    <div class="dashboard">
        <?php
        if ($result->num_rows > 0) {
            echo "<h2 style='letter-spacing: 2px;'>ALL STATUS</h2><br>";
            echo "<ul>";
            while ($row = $result->fetch_assoc()) {
                echo "<li><img src='user.png' alt='Pin Icon' style='width: 50px; height: 50px; margin-bottom: -20px;'> 
                        <strong style='letter-spacing: 1px; color: #FFB534; font-size: 20px; margin-left: 5px;'>" . $row['name'] . "</strong>
                        <div style='color: #B6BBC4; font-size: 12px; margin-left: 57px;'>Updated on " . date('F j, Y, g:i a', strtotime($row['datetime'])) . "</div>
                        <hr style='border: 1px solid gray; margin-top: 15px;'>
                        <p style='font-size: 16px; margin-top: 20px;'>Status : " . $row['status'] . "<p></li>";
            }
            echo "</ul>";
        } else {
            echo "<br>No statuses found in the database.";
        }
        ?>
    </div>

</body>

</html>

